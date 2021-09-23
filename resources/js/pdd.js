console.log('pdd');

// 设置localCurrency
var pddLocalCurrency = window.localStorage.getItem('pddLocalCurrency');
if (!pddLocalCurrency) {
    fetch(pddBaseUrl + "/pdd/ip?shop=" + pddShopDomain).then(response => {
        return response.json();
    }).then(json => {
        if (json.geoplugin_currencyCode) {
            pddLocalCurrency = json.geoplugin_currencyCode;
            window.localStorage.setItem('pddLocalCurrency', json.geoplugin_currencyCode)
        } else {
            pddLocalCurrency = shopCurrency;
            window.localStorage.setItem('pddLocalCurrency', shopCurrency)
        }
    })
}
// 设置pddLocationTimestamp
var pddLocationTimestamp = window.localStorage.getItem('pddLocationTimestamp');
if (!pddLocationTimestamp) {
    window.localStorage.setItem('pddLocationTimestamp', new Date());
}

var antiCurrencyWidget = window.localStorage.getItem('antiCurrencyWidget');

// 写入customCode
var customStyle = document.createElement('style');
customStyle.type = "text/css";
customStyle.textContent = pddCustomCode.custom_css;
document.head.appendChild(customStyle);
var customScript = document.createElement('script');
customScript.textContent = pddCustomCode.custom_js;
document.body.appendChild(customScript);

function makeid(length) {
    var result = '';
    var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}

if (!window.localStorage.getItem('pddClientID')) {
    window.localStorage.setItem('pddClientID', makeid(18));
}

var cartInfo = {};
async function getCart() {
    var respons = await fetch("/cart.js");
    var json = await respons.json();
    console.log(json);
    cartInfo = json;
    return json;
}

getCart().then(res => getBars());


(function (ns, fetch) {
    if (typeof fetch !== 'function') return;

    ns.fetch = function () {
        const response = fetch.apply(this, arguments);

        response.then(res => {
            if ([
                `${window.location.origin}/cart.js`,
                `${window.location.origin}/cart/add.js`,
                `${window.location.origin}/cart/update.js`,
                `${window.location.origin}/cart/change.js`,
                `${window.location.origin}/cart/clear.js`,
                `${window.location.origin}/cart`,
                `${window.location.origin}/cart/add`,
                `${window.location.origin}/cart/update`,
                `${window.location.origin}/cart/change`,
                `${window.location.origin}/cart/clear`,
            ].includes(res.url)) {
                res.clone().json().then(data => {
                    console.log('fetch observer data');
                    cartInfo = data;
                    rebuild();
                });
            }
        });

        return response;
    }

}(window, window.fetch))

var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
var startTime = (new Date()).getTime();
var bars = [];

// 这里获取shipping bars
async function getBars() {
    fetch(pddBaseUrl + "/pdd/shippingbar?shop=" + pddShopDomain +
        "&pageType=" + window.location.pathname +
        "&time=" + startTime)
        .then(function (response) {
            return response.json();
        })
        .then(function (json) {
            bars = json;
            rebuild();
        });
}

// top bars
var currentTopBarIndex = 0;
var topBarInterval = null;
var tpbs = [];
// bottom bars
var currentBottomBarIndex = 0;
var bottomBarInterval = null;
var bpbs = [];
// custom bars
var currentCustomBarIndex = 0;
var customBarInterval = null;
var cpbs = [];
// custom sticky bars
var currentCustomStickyBarIndex = 0;
var customStickyBarInterval = null;
var csbs = [];
async function rebuild() {
    console.log('rebuild');
    // ban掉geo targets
    var pddLocalCurrency = window.localStorage.getItem('pddLocalCurrency');
    if (pddLocalCurrency) {
        var shouldRemoveBarIds = [];
        bars.forEach(bar => {
            if (bar.geo_targets.length > 0) {
                var find = bar.geo_targets.find(c => c === pddLocalCurrency);
                if (!find) {
                    // remove the bar
                    shouldRemoveBarIds.push(bar.id)
                }
            }
        });
        bars = bars.filter(b => !shouldRemoveBarIds.includes(b.id))
    }
    // ban掉show_on
    var shouldHideOnThisScreenIds = [];
    var screen = window.screen;
    bars.forEach(bar => {
        if (bar.show_on === 'desktop' && screen.width < 768) {
            shouldHideOnThisScreenIds.push(bar.id);
        }
        if (bar.show_on === 'mobile' && screen.width >= 768) {
            shouldHideOnThisScreenIds.push(bar.id);
        }
    });
    bars = bars.filter(b => !shouldHideOnThisScreenIds.includes(b.id));

    var topBars = bars.filter(b => b.display_position === 'TOP');
    var bottomBars = bars.filter(b => b.display_position === 'BOTTOM');
    var customBars = bars.filter(b => b.display_position === 'CUSTOM');
    // first run ban logic
    var pddBanBarIds = JSON.parse(window.localStorage.getItem('pddBanBarIds'));
    var pddBanBarTimes = JSON.parse(window.localStorage.getItem('pddBanBarTimes'));

    if (pddBanBarIds && pddBanBarTimes && pddBanBarIds.length == pddBanBarTimes.length) {
        var now = new Date();
        // update pddBanBarIds
        var deleteIndex = [];
        pddBanBarIds.forEach((id, index) => {
            var banTime = new Date(pddBanBarTimes[index]);
            var barById = bars.find(b => b.id === id);
            var gapDays = (now - banTime) / (1000 * 60 * 60 * 24);
            if (gapDays > barById.expires_days) {
                deleteIndex.push(index);
            }
        })
        console.log('deleteIndex:' + JSON.stringify(deleteIndex));
        pddBanBarIds = pddBanBarIds.filter((p, index) => !deleteIndex.includes(index));
        pddBanBarTimes = pddBanBarTimes.filter((p, index) => !deleteIndex.includes(index));
        console.log(pddBanBarIds);
        // update localStorage
        if (deleteIndex.length > 0) {
            window.localStorage.setItem('pddBanBarIds', JSON.stringify(pddBanBarIds));
            window.localStorage.setItem('pddBanBarTimes', JSON.stringify(pddBanBarTimes));
        }
        // build filteredBars
        var filteredBars = bars.filter(b => !pddBanBarIds.includes(b.id));
        console.log('filteredBars.length=' + filteredBars.length);
        topBars = filteredBars.filter(b => b.display_position === 'TOP');
        bottomBars = filteredBars.filter(b => b.display_position === 'BOTTOM');
        customBars = filteredBars.filter(b => b.display_position === 'CUSTOM');
    } else {
        // localStorage broken
        window.localStorage.removeItem('pddBanBarIds');
        window.localStorage.removeItem('pddBanBarTimes');
    }
    console.log('topBars.length=' + topBars.length);
    console.log('bottomBars.length=' + bottomBars.length);
    console.log('customBars.length=' + customBars.length);
    clearInterval(topBarInterval);
    clearInterval(bottomBarInterval);
    clearInterval(customBarInterval);

    buildTopShippingBars(topBars).then(res => {
        if (topBars.length === 0) return;
        tpbs = document.querySelectorAll('.pdd-top-bar');
        topBarInterval = setInterval(() => {
            if (tpbs.length <= 1) {
                clearInterval(topBarInterval);
                return;
            }
            currentTopBarIndex++;
            if (currentTopBarIndex < tpbs.length) {
                tpbs[currentTopBarIndex - 1].style.display = "none";
                tpbs[currentTopBarIndex].style.display = "flex";
            } else {
                tpbs[tpbs.length - 1].style.display = "none";
                tpbs[0].style.display = "flex";
                currentTopBarIndex = 0;
            }
        }, 7000);
    });
    buildBottomShippingBars(bottomBars).then(res => {
        if (bottomBars.length === 0) return;
        bpbs = document.querySelectorAll('.pdd-bottom-bar');
        bottomBarInterval = setInterval(() => {
            if (bpbs.length <= 1) {
                clearInterval(bottomBarInterval);
                return;
            }
            currentBottomBarIndex++;
            if (currentBottomBarIndex < bpbs.length) {
                bpbs[currentBottomBarIndex - 1].style.display = "none";
                bpbs[currentBottomBarIndex].style.display = "flex";
            } else {
                bpbs[bpbs.length - 1].style.display = "none";
                bpbs[0].style.display = "flex";
                currentBottomBarIndex = 0;
            }
        }, 7000);
    });
    buildCustomShippingBars(customBars).then(res => {
        if (customBars.length === 0) return;
        cpbs = document.querySelectorAll('.pdd-cb-bar');
        console.log('cpbs.length=' + cpbs.length);
        console.log('customBars.length=' + customBars.length);
        var group = cpbs.length / customBars.length;
        console.log('group:' + group);
        customBarInterval = setInterval(() => {
            if (cpbs.length <= 1) {
                clearInterval(customBarInterval);
                return;
            }
            currentCustomBarIndex++;
            if (currentCustomBarIndex < customBars.length) {
                var shouldHideById = document.querySelectorAll("#pdd-cb-bar-" + (currentCustomBarIndex - 1));
                shouldHideById.forEach(s => {
                    s.style.display = 'none';
                })
                var shouldShowById = document.querySelectorAll('#pdd-cb-bar-' + currentCustomBarIndex);
                shouldShowById.forEach(s => {
                    s.style.display = "flex";
                })
            } else {
                var lastHideById = document.querySelectorAll("#pdd-cb-bar-" + (customBars.length - 1));
                lastHideById.forEach(l => {
                    l.style.display = "none";
                });
                var firstShowById = document.querySelectorAll("#pdd-cb-bar-0");
                firstShowById.forEach(f => {
                    f.style.display = "flex";
                })
                currentCustomBarIndex = 0;
            }
        }, 7000);
    });
    buildCustomStickyShippingBars(customBars).then(res => {
        if (customBars.length === 0) return;
        csbs = document.querySelectorAll('.pdd-cb-sticky-bar');
        console.log('csbs.length=' + csbs.length);
        console.log('customBars.length=' + customBars.length);
        var group = csbs.length / customBars.length;
        console.log('group:' + group);
        customStickyBarInterval = setInterval(() => {
            if (csbs.length <= 1) {
                clearInterval(customStickyBarInterval);
                return;
            }
            currentCustomStickyBarIndex++;
            if (currentCustomStickyBarIndex < customBars.length) {
                var shouldHideById = document.querySelectorAll("#pdd-cb-sticky-bar-" + (currentCustomStickyBarIndex - 1));
                shouldHideById.forEach(s => {
                    s.style.display = 'none';
                })
                var shouldShowById = document.querySelectorAll('#pdd-cb-sticky-bar-' + currentCustomStickyBarIndex);
                shouldShowById.forEach(s => {
                    s.style.display = "flex";
                })
            } else {
                var lastHideById = document.querySelectorAll("#pdd-cb-sticky-bar-" + (customBars.length - 1));
                lastHideById.forEach(l => {
                    l.style.display = "none";
                });
                var firstShowById = document.querySelectorAll("#pdd-cb-sticky-bar-0");
                firstShowById.forEach(f => {
                    f.style.display = "flex";
                })
                currentCustomStickyBarIndex = 0;
            }
        }, 7000);
    })
}

// layout1 style
var layout1 = "display:flex;align-items:center;padding:0 5px;position:relative;";
var layout1_subdiv = "display:flex;justify-content:center;align-items:center;flex-grow:1;z-index:100;";
var layout1_bg_image = "-o-object-fit:cover;object-fit:cover;position:absolute;top:0;left:0;width:100%;";
var layout1_message_1 = "";
var layout1_message_2 = "";
var layout1_special = "margin: 0 5px;";
var layout1_link = "display:flex;justify-content:center;align-items:center;flex-grow:1;z-index:100;";
var layout1_close_btn = "display:flex;z-index:100;";

async function fadeIn(element) {
    var op = 0.1; // initial opacity
    element.style.display = 'flex';
    var timer = setInterval(function () {
        if (op >= element.dataset.opacity / 100) {
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, 20);
}

async function fadeOut(element) {
    var op = element.dataset.opacity / 100; // initial opacity
    var timer = setInterval(function () {
        if (op <= 0.1) {
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, 40);
}

// 这里开始build shipping bars, 注意layout
async function buildTopShippingBars(topBars) {
    // delete all top bars
    var tbs = document.querySelector('.pdd-top-bars');
    if (tbs) {
        tbs.innerHTML = "";
    } else {
        tbs = document.createElement('div');
        tbs.classList.add('pdd-top-bars');
        if (topBars.length > 1) {
            tbs.style.height = 'fit-content';
            tbs.style.width = "100%";
        }
        document.body.prepend(tbs);
    }
    topBars.forEach((b, index) => {
        // add google font
        var font = document.getElementById(b.font.split(" ").join("+"));
        if (!font) {
            var link = document.createElement('link');
            link.rel = "stylesheet";
            link.id = b.font.split(" ").join("+");
            link.href = "https://fonts.googleapis.com/css?family=" + b.font.split(" ").join("+");
            document.head.appendChild(link)
        }
        var pddCbBar = document.createElement('div');
        pddCbBar.id = "pdd-top-bar-" + index;
        pddCbBar.classList.add("pdd-top-bar");
        pddCbBar.style = layout1;
        pddCbBar.style.opacity = b.bg_opacity / 100;
        pddCbBar.style.height = b.height ? b.height : '40px';
        pddCbBar.dataset.opacity = b.bg_opacity;
        pddCbBar.dataset.index = index;
        if (index > 0) {
            pddCbBar.style.display = "none";
        }
        if (b.bg_image !== null && b.bg_image !== "") {
            var pddCbBgImage = document.createElement('img');
            pddCbBgImage.src = b.bg_image;
            pddCbBgImage.style = layout1_bg_image;
            pddCbBgImage.style.height = b.height;
            pddCbBar.append(pddCbBgImage);
        } else {
            pddCbBar.style.background = b.bg_color;
        }

        var pddCbLink = "";
        if (b.add_link) {
            pddCbLink = document.createElement('a');
            pddCbLink.href = b.link;
            pddCbLink.target = "_blank"; // 这也是一个设置项
            pddCbLink.style = layout1_link;
            pddCbLink.style.cursor = 'pointer';
            pddCbLink.addEventListener('click', (e) => {
                stats('click');
                click(b.id);
            });
        } else {
            pddCbLink = document.createElement('div');
            pddCbLink.style = layout1_subdiv;
        }
        pddCbLink.style.color = b.text_color;
        pddCbLink.style.fontFamily = b.font ? b.font : 'sans-serif';
        pddCbLink.style.fontSize = b.font_size ? b.font_size : '16px';
        pddCbBar.append(pddCbLink);

        if (b.add_close_btn) {
            var pddCloseBtn = document.createElement('div');
            pddCloseBtn.style = layout1_close_btn;
            pddCloseBtn.innerHTML = '<svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            pddCloseBtn.id = "pdd-close-btn-" + index;
            pddCloseBtn.classList.add('pdd-close-btn');
            pddCloseBtn.style.color = b.close_btn_color;
            pddCloseBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                pddCbBar.style.display = "none";
                var pddBanBarIds = JSON.parse(window.localStorage.getItem('pddBanBarIds'));
                if (!pddBanBarIds) {
                    window.localStorage.setItem('pddBanBarIds', JSON.stringify([b.id]));
                } else {
                    window.localStorage.setItem('pddBanBarIds', JSON.stringify([...pddBanBarIds, b.id]));
                }
                var pddBanBarTimes = JSON.parse(window.localStorage.getItem('pddBanBarTimes'));
                if (!pddBanBarTimes) {
                    window.localStorage.setItem('pddBanBarTimes', JSON.stringify([new Date().getTime()]));
                } else {
                    window.localStorage.setItem('pddBanBarTimes', JSON.stringify([...pddBanBarTimes, new Date().getTime()]))
                }
                stats('click');
                click(b.id);
                rebuild();
            });
            pddCbBar.append(pddCloseBtn);
        }

        var pddMessage1 = document.createElement('div');
        pddMessage1.style = layout1_message_1;
        var pddMessage2 = document.createElement('div');
        pddMessage2.style = layout1_message_2;
        var pddMessageSpecial = document.createElement('div');
        pddMessageSpecial.style = layout1_special;
        pddMessageSpecial.style.color = b.shipping_goal_text_color;

        whichMessage(b).then(res => {
            pddMessage1.innerHTML = res.message1;
            pddMessage2.innerHTML = res.message2;
            pddMessageSpecial.innerHTML = res.message_special;
            pddCbLink.append(pddMessage1);
            pddCbLink.append(pddMessageSpecial);
            pddCbLink.append(pddMessage2);
            tbs.append(pddCbBar);
        });
    });
}

async function buildBottomShippingBars(bottomBars) {
    // delete all top bars
    var bbs = document.querySelector('.pdd-bottom-bars');
    if (bbs) {
        bbs.innerHTML = "";
    } else {
        bbs = document.createElement('div');
        bbs.classList.add('pdd-bottom-bars');
        bbs.style.height = 'fit-content';
        bbs.style.width = "100%";
        bbs.style.position = "fixed";
        bbs.style.bottom = 0;
        bbs.style.left = 0;
        bbs.style.zIndex = 999;

        document.body.prepend(bbs);
    }
    if (bottomBars.length > 0) {
        document.body.style.paddingBottom = "40px";
    }
    bottomBars.forEach((b, index) => {
        // add google font
        var font = document.getElementById(b.font.split(" ").join("+"));
        if (!font) {
            var link = document.createElement('link');
            link.rel = "stylesheet";
            link.id = b.font.split(" ").join("+");
            link.href = "https://fonts.googleapis.com/css?family=" + b.font.split(" ").join("+");
            document.head.appendChild(link)
        }
        var pddCbBar = document.createElement('div');
        pddCbBar.id = "pdd-bottom-bar-" + index;
        pddCbBar.classList.add("pdd-bottom-bar");
        pddCbBar.style = layout1;
        pddCbBar.style.opacity = b.bg_opacity / 100;
        pddCbBar.style.height = b.height ? b.height : '40px';
        pddCbBar.dataset.opacity = b.bg_opacity;
        pddCbBar.dataset.index = index;
        if (index > 0) {
            pddCbBar.style.display = "none";
        }
        if (b.bg_image !== null && b.bg_image !== "") {
            var pddCbBgImage = document.createElement('img');
            pddCbBgImage.src = b.bg_image;
            pddCbBgImage.style = layout1_bg_image;
            pddCbBgImage.style.height = b.height;
            pddCbBar.append(pddCbBgImage);
        } else {
            pddCbBar.style.background = b.bg_color;
        }

        var pddCbLink = "";
        if (b.add_link) {
            pddCbLink = document.createElement('a');
            pddCbLink.href = b.link;
            pddCbLink.target = "_blank"; // 这也是一个设置项
            pddCbLink.style = layout1_link;
            pddCbLink.style.cursor = 'pointer';
            pddCbLink.addEventListener('click', (e) => {
                stats('click');
                click(b.id);
            });
        } else {
            pddCbLink = document.createElement('div');
            pddCbLink.style = layout1_subdiv;
        }
        pddCbLink.style.color = b.text_color;
        pddCbLink.style.fontFamily = b.font ? b.font : 'sans-serif';
        pddCbLink.style.fontSize = b.font_size ? b.font_size : '16px';
        pddCbBar.append(pddCbLink);

        if (b.add_close_btn) {
            var pddCloseBtn = document.createElement('div');
            pddCloseBtn.style = layout1_close_btn;
            pddCloseBtn.innerHTML = '<svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            pddCloseBtn.id = "pdd-close-btn-" + index;
            pddCloseBtn.classList.add('pdd-close-btn');
            pddCloseBtn.style.color = b.close_btn_color;
            pddCloseBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                pddCbBar.style.display = "none";
                var pddBanBarIds = JSON.parse(window.localStorage.getItem('pddBanBarIds'));
                if (!pddBanBarIds) {
                    window.localStorage.setItem('pddBanBarIds', JSON.stringify([b.id]));
                } else {
                    window.localStorage.setItem('pddBanBarIds', JSON.stringify([...pddBanBarIds, b.id]));
                }
                var pddBanBarTimes = JSON.parse(window.localStorage.getItem('pddBanBarTimes'));
                if (!pddBanBarTimes) {
                    window.localStorage.setItem('pddBanBarTimes', JSON.stringify([new Date().getTime()]));
                } else {
                    window.localStorage.setItem('pddBanBarTimes', JSON.stringify([...pddBanBarTimes, new Date().getTime()]))
                }
                stats('click');
                click(b.id);
                rebuild();
            });
            pddCbBar.append(pddCloseBtn);
        }

        var pddMessage1 = document.createElement('div');
        pddMessage1.style = layout1_message_1;
        var pddMessage2 = document.createElement('div');
        pddMessage2.style = layout1_message_2;
        var pddMessageSpecial = document.createElement('div');
        pddMessageSpecial.style = layout1_special;
        pddMessageSpecial.style.color = b.shipping_goal_text_color;

        whichMessage(b).then(res => {
            pddMessage1.innerHTML = res.message1;
            pddMessage2.innerHTML = res.message2;
            pddMessageSpecial.innerHTML = res.message_special;
            pddCbLink.append(pddMessage1);
            pddCbLink.append(pddMessageSpecial);
            pddCbLink.append(pddMessage2);
            bbs.append(pddCbBar);
        });
    });
}

async function buildCustomShippingBars(customBars) {
    // delete all top bars
    var cbbs = document.querySelectorAll('.pdd-cb-bars');
    if (cbbs.length > 0) {
        cbbs.forEach((cbb, index) => {
            cbb.innerHTML = "";
            cbb.style.height = "fit-content";
            cbb.style.width = "100%";
            // 这里开始
            customBars.forEach((b, index) => {
                // add google font
                var font = document.getElementById(b.font.split(" ").join("+"));
                if (!font) {
                    var link = document.createElement('link');
                    link.rel = "stylesheet";
                    link.id = b.font.split(" ").join("+");
                    link.href = "https://fonts.googleapis.com/css?family=" + b.font.split(" ").join("+");
                    document.head.appendChild(link)
                }
                var pddCbBar = document.createElement('div');
                pddCbBar.id = "pdd-cb-bar-" + index;
                pddCbBar.classList.add("pdd-cb-bar");
                pddCbBar.style = layout1;
                pddCbBar.style.opacity = b.bg_opacity / 100;
                pddCbBar.style.height = b.height ? b.height : '40px';
                pddCbBar.dataset.opacity = b.bg_opacity;
                pddCbBar.dataset.index = index;
                if (index > 0) {
                    pddCbBar.style.display = "none";
                }
                if (b.bg_image !== null && b.bg_image !== "") {
                    var pddCbBgImage = document.createElement('img');
                    pddCbBgImage.src = b.bg_image;
                    pddCbBgImage.style = layout1_bg_image;
                    pddCbBgImage.style.height = b.height;
                    pddCbBar.append(pddCbBgImage);
                } else {
                    pddCbBar.style.background = b.bg_color;
                }

                var pddCbLink = "";
                if (b.add_link) {
                    pddCbLink = document.createElement('a');
                    pddCbLink.href = b.link;
                    pddCbLink.target = "_blank"; // 这也是一个设置项
                    pddCbLink.style = layout1_link;
                    pddCbLink.style.cursor = 'pointer';
                    pddCbLink.addEventListener('click', (e) => {
                        stats('click');
                        click(b.id);
                    });
                } else {
                    pddCbLink = document.createElement('div');
                    pddCbLink.style = layout1_subdiv;
                }
                pddCbLink.style.color = b.text_color;
                pddCbLink.style.fontFamily = b.font ? b.font : 'sans-serif';
                pddCbLink.style.fontSize = b.font_size ? b.font_size : '16px';
                pddCbBar.append(pddCbLink);

                if (b.add_close_btn) {
                    var pddCloseBtn = document.createElement('div');
                    pddCloseBtn.style = layout1_close_btn;
                    pddCloseBtn.innerHTML = '<svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    pddCloseBtn.id = "pdd-close-btn-" + index;
                    pddCloseBtn.classList.add('pdd-close-btn');
                    pddCloseBtn.style.color = b.close_btn_color;
                    pddCloseBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        pddCbBar.style.display = "none";
                        var pddBanBarIds = JSON.parse(window.localStorage.getItem('pddBanBarIds'));
                        if (!pddBanBarIds) {
                            window.localStorage.setItem('pddBanBarIds', JSON.stringify([b.id]));
                        } else {
                            window.localStorage.setItem('pddBanBarIds', JSON.stringify([...pddBanBarIds, b.id]));
                        }
                        var pddBanBarTimes = JSON.parse(window.localStorage.getItem('pddBanBarTimes'));
                        if (!pddBanBarTimes) {
                            window.localStorage.setItem('pddBanBarTimes', JSON.stringify([new Date().getTime()]));
                        } else {
                            window.localStorage.setItem('pddBanBarTimes', JSON.stringify([...pddBanBarTimes, new Date().getTime()]))
                        }
                        stats('click');
                        click(b.id);
                        rebuild();
                    });
                    pddCbBar.append(pddCloseBtn);
                }

                var pddMessage1 = document.createElement('div');
                pddMessage1.style = layout1_message_1;
                var pddMessage2 = document.createElement('div');
                pddMessage2.style = layout1_message_2;
                var pddMessageSpecial = document.createElement('div');
                pddMessageSpecial.style = layout1_special;
                pddMessageSpecial.style.color = b.shipping_goal_text_color;

                whichMessage(b).then(res => {
                    pddMessage1.innerHTML = res.message1;
                    pddMessage2.innerHTML = res.message2;
                    pddMessageSpecial.innerHTML = res.message_special;
                    pddCbLink.append(pddMessage1);
                    pddCbLink.append(pddMessageSpecial);
                    pddCbLink.append(pddMessage2);
                    cbb.append(pddCbBar);
                });
            });
        })
    }
}

async function buildCustomStickyShippingBars(customBars) {
    var sticky_cbbs = document.querySelectorAll('.pdd-cb-sticky-bars');
    if (sticky_cbbs.length > 0) {
        sticky_cbbs.forEach((cbb, index) => {
            cbb.innerHTML = "";
            cbb.style.height = "fit-content";
            cbb.style.width = "100%";
            cbb.style.position = "sticky";
            cbb.style.top = 0;
            cbb.style.zIndex = 999;
            // 这里开始
            customBars.forEach((b, index) => {
                // add google font
                var font = document.getElementById(b.font.split(" ").join("+"));
                if (!font) {
                    var link = document.createElement('link');
                    link.rel = "stylesheet";
                    link.id = b.font.split(" ").join("+");
                    link.href = "https://fonts.googleapis.com/css?family=" + b.font.split(" ").join("+");
                    document.head.appendChild(link)
                }
                var pddCbBar = document.createElement('div');
                pddCbBar.id = "pdd-cb-bar-" + index;
                pddCbBar.classList.add("pdd-cb-sticky-bar");
                pddCbBar.style = layout1;
                pddCbBar.style.opacity = b.bg_opacity / 100;
                pddCbBar.style.height = b.height ? b.height : '40px';
                pddCbBar.dataset.opacity = b.bg_opacity;
                pddCbBar.dataset.index = index;
                if (index > 0) {
                    pddCbBar.style.display = "none";
                }
                if (b.bg_image !== null && b.bg_image !== "") {
                    var pddCbBgImage = document.createElement('img');
                    pddCbBgImage.src = b.bg_image;
                    pddCbBgImage.style = layout1_bg_image;
                    pddCbBgImage.style.height = b.height;
                    pddCbBar.append(pddCbBgImage);
                } else {
                    pddCbBar.style.background = b.bg_color;
                }

                var pddCbLink = "";
                if (b.add_link) {
                    pddCbLink = document.createElement('a');
                    pddCbLink.href = b.link;
                    pddCbLink.target = "_blank"; // 这也是一个设置项
                    pddCbLink.style = layout1_link;
                    pddCbLink.style.cursor = 'pointer';
                    pddCbLink.addEventListener('click', (e) => {
                        stats('click');
                        click(b.id);
                    });
                } else {
                    pddCbLink = document.createElement('div');
                    pddCbLink.style = layout1_subdiv;
                }
                pddCbLink.style.color = b.text_color;
                pddCbLink.style.fontFamily = b.font ? b.font : 'sans-serif';
                pddCbLink.style.fontSize = b.font_size ? b.font_size : '16px';
                pddCbBar.append(pddCbLink);

                if (b.add_close_btn) {
                    var pddCloseBtn = document.createElement('div');
                    pddCloseBtn.style = layout1_close_btn;
                    pddCloseBtn.innerHTML = '<svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                    pddCloseBtn.id = "pdd-close-btn-" + index;
                    pddCloseBtn.classList.add('pdd-close-btn');
                    pddCloseBtn.style.color = b.close_btn_color;
                    pddCloseBtn.addEventListener('click', (e) => {
                        e.stopPropagation();
                        pddCbBar.style.display = "none";
                        var pddBanBarIds = JSON.parse(window.localStorage.getItem('pddBanBarIds'));
                        if (!pddBanBarIds) {
                            window.localStorage.setItem('pddBanBarIds', JSON.stringify([b.id]));
                        } else {
                            window.localStorage.setItem('pddBanBarIds', JSON.stringify([...pddBanBarIds, b.id]));
                        }
                        var pddBanBarTimes = JSON.parse(window.localStorage.getItem('pddBanBarTimes'));
                        if (!pddBanBarTimes) {
                            window.localStorage.setItem('pddBanBarTimes', JSON.stringify([new Date().getTime()]));
                        } else {
                            window.localStorage.setItem('pddBanBarTimes', JSON.stringify([...pddBanBarTimes, new Date().getTime()]))
                        }
                        stats('click');
                        click(b.id);
                        rebuild();
                    });
                    pddCbBar.append(pddCloseBtn);
                }

                var pddMessage1 = document.createElement('div');
                pddMessage1.style = layout1_message_1;
                var pddMessage2 = document.createElement('div');
                pddMessage2.style = layout1_message_2;
                var pddMessageSpecial = document.createElement('div');
                pddMessageSpecial.style = layout1_special;
                pddMessageSpecial.style.color = b.shipping_goal_text_color;

                whichMessage(b).then(res => {
                    pddMessage1.innerHTML = res.message1;
                    pddMessage2.innerHTML = res.message2;
                    pddMessageSpecial.innerHTML = res.message_special;
                    pddCbLink.append(pddMessage1);
                    pddCbLink.append(pddMessageSpecial);
                    pddCbLink.append(pddMessage2);
                    cbb.append(pddCbBar);
                });
            });
        })
    }
}

// 转换成cartCurrency后计算
async function whichMessage(bar) {
    var cartCurrency = currencies.find(c => c.currency === cartInfo.currency);
    antiCurrencyWidget = window.localStorage.getItem('antiCurrencyWidget');
    // 是否自动转换成本地货币
    if (bar.currency_conversion) {
        if (antiCurrencyWidget) { // 这里和Currency Converter Ant联动
            cartCurrency = currencies.find(c => c.currency === antiCurrencyWidget)
        } else {
            cartCurrency = currencies.find(c => c.currency === pddLocalCurrency);
        }
    }
    console.log('cartCurrency:' + JSON.stringify(cartCurrency));
    window.localStorage.setItem('pddDisplayCurrency', cartCurrency.currency);
    var shippingAmount = Currency.convert(bar.shipping_goal, bar.shipping_goal_currency, cartCurrency.currency);
    console.log('shippingAmount:' + shippingAmount);
    var cartAmount = Currency.convert(cartInfo.total_price / 100, cartInfo.currency, cartCurrency.currency);
    console.log('cartAmount:' + cartAmount);
    if (parseFloat(cartAmount) === 0) {
        return {
            "message1": bar.init_message_1,
            "message2": bar.init_message_2,
            "message_special": cartCurrency.currency_symbol + Number(shippingAmount).toFixed(0)
        }
    } else if (cartAmount < shippingAmount) {
        console.log("小于");
        return {
            "message1": bar.progress_message_1,
            "message2": bar.progress_message_2,
            "message_special": cartCurrency.currency_symbol + Number(shippingAmount - cartAmount).toFixed(1)
        }
    }
    return {
        "message1": bar.achieved_message_1,
        "message2": bar.achieved_message_2,
        "message_special": ""
    }
}

// 这里开始上报数据
async function stats(from) {
    var client_id = window.localStorage.getItem('pddClientID');
    var currency_display = window.localStorage.getItem('pddDisplayCurrency');
    var currency_location = window.localStorage.getItem('pddLocalCurrency');
    var location_timestamp = window.localStorage.getItem('pddLocationTimestamp');
    var ban_bar_ids = JSON.stringify(window.localStorage.getItem('pddBanBarIds'));
    var ban_bar_times = JSON.stringify(window.localStorage.getItem('pddBanBarTimes'));
    var response = await fetch(pddBaseUrl + '/pdd/stats', {
        method: 'POST',
        headers: {
            'content-type': 'application/json'
        },
        body: JSON.stringify({
            shop: pddShopDomain,
            client_id: client_id,
            currency_display: currency_display,
            currency_location: currency_location,
            location_timestamp: location_timestamp,
            ban_bar_ids: ban_bar_ids,
            ban_bar_times: ban_bar_times,
            from: from,
            stats_at: (new Date()).getTime()
        })
    });
    var json = await response.json();
    console.log(json);
}

async function click(id) {
    var client_id = window.localStorage.getItem('pddClientID');
    var currency_display = window.localStorage.getItem('pddDisplayCurrency');
    var currency_location = window.localStorage.getItem('pddLocalCurrency');
    var location_timestamp = window.localStorage.getItem('pddLocationTimestamp');
    var ban_bar_ids = JSON.stringify(window.localStorage.getItem('pddBanBarIds'));
    var ban_bar_times = JSON.stringify(window.localStorage.getItem('pddBanBarTimes'));
    var response = await fetch(pddBaseUrl + '/pdd/click', {
        method: 'POST',
        headers: {
            'content-type': 'application/json'
        },
        body: JSON.stringify({
            shop: pddShopDomain,
            client_id: client_id,
            currency_display: currency_display,
            currency_location: currency_location,
            location_timestamp: location_timestamp,
            ban_bar_ids: ban_bar_ids,
            ban_bar_times: ban_bar_times,
            bar_id: id,
            stats_at: (new Date()).getTime()
        })
    });
    var json = await response.json();
    console.log(json);
}

stats('load');
