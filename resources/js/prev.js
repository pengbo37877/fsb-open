<div class="pdd-shop-domain" style="display:none">{{shop.permanent_domain}}</div>
<div class="pdd-shop-currency" style="display:none">{{shop.currency}}</div>
<div class="pdd-cart-total-price" style="display:none">{{ cart.total_price }}</div>
<div class="pdd-cart-currency" style="display:none">{{ cart.currency.iso_code }}</div>
<div class="pdd-request-type" style="display:none">{{ request.page_type }}</div>
<div class="pdd-request-path" style="display:none">{{ request.path }}</div>
<div class="pdd-product-id" style="display:none">{{ product.id }}</div>

<style>
 @media only screen and (min-width: 500px){
  .top-bars {
  	display: flex;
    flex-direction: column;
  }
  .bottom-bars {
  	position: fixed;
    left: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    width: 100%;
    height: auto;
    z-index: 10000;
  }
  .pdd-wrap {
  	position: relative;
    width: 100%;
    height: 56px;
    display: flex;
  }
  .pdd-shipping-bar{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    height: 56px;
    line-height: 56px;
    padding: 0 20px;
  }
  .pdd-message{
    display: flex;
    font-size: 20px;
    font-weight: 400;
    line-height: 56px;
  }
  .pdd-msg-goal {
    
  }
  .pdd-close-btn {
    opacity: 0;
  	padding: 6px 0;
    color: white;
  }
  .pdd-bg-image-wrap{
    overflow: hidden;
    position: relative;
    width: 100%;
    height: 56px;
  }
  .pdd-bg-image{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    opacity: .5;
  }
  .pdd-none {
  	display: none;
  }
 }
  
 @media only screen and (max-width: 500px){
  .top-bars {
  	display: flex;
    flex-direction: column;
  }
  .bottom-bars {
  	position: fixed;
    left: 0;
    bottom: 0;
    display: flex;
    flex-direction: column;
    width: 100%;
    height: auto;
    z-index: 10000;
  }
  .pdd-wrap {
  	position: relative;
    width: 100%;
    height: 56px;
    display: flex;
  }
  .pdd-shipping-bar{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    height: 56px;
    line-height: 56px;
    padding: 0 20px;
  }
  .pdd-message{
    display: flex;
    font-size: 16px;
    font-weight: 400;
    line-height: 56px;
  }
  .pdd-msg-goal {
    
  }
  .pdd-close-btn {
    opacity: 0;
  	padding: 6px 0;
    color: white;
  }
  .pdd-bg-image-wrap{
    overflow: hidden;
    position: relative;
    width: 100%;
    height: 56px;
  }
  .pdd-bg-image{
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: auto;
    opacity: .5;
  }
  .pdd-none {
  	display: none;
  }
 }
</style>

<script type="text/javascript">
  var url = "https://fsb.pb-apps.com";
  var shopDomain = document.querySelector('.pdd-shop-domain').innerHTML;
  
  // var cartTotalPrice = document.querySelector('.pdd-cart-total-price').innerHTML;
  var cartCurrency = document.querySelector('.pdd-cart-currency').innerHTML;
  var shopCurrency = document.querySelector('.pdd-shop-currency').innerHTML;
  var requestType = document.querySelector('.pdd-request-type').innerHTML;
  var requestPath = document.querySelector('.pdd-request-path').innerHTML;
  var productId = document.querySelector('.pdd-product-id').innerHTML;
  var timeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  var startTime = (new Date()).getTime();

  let addToCartForm = document.querySelector('form[action="/cart/add"]');
  var that = this;
  
  if(addToCartForm) {
    addToCartForm.addEventListener('submit', function(e){
      e.preventDefault();
      let formData = new FormData(addToCartForm);

      fetch('/cart/add.js', {
         method: 'POST',
         body: formData
      })
      .then(response => {
        return response.json();
      })
      .then(json => {
        console.log('add cart');
        console.log(json);
        that.fetchCart();
      })
      .catch((error) => {
        console.error('Error:', error);
      });
    });
  }
  
  let cartChanges = document.querySelectorAll('a[href^="/cart/change"]');
  
  cartChanges.forEach(c => {
    if(c) {
      c.addEventListener('click', function(e) {
        setTimeout(()=>{
          console.log('cartChanges');
          that.fetchCart();           
        }, 1000);
      });
    }
  });
  
  var start = new Date();
  var end = "";
  var time = 0;
  var jsonObject = [];
  fetch(url+"/pdd/shippingbar?shop="+shopDomain+
        "&shopCurrency="+shopCurrency+
        "&cartCurrency="+cartCurrency+
        "&pageType="+requestType+
        "&timeZone="+timeZone+
        "&time="+startTime)
    .then(function (response){
      return response.json();
    })
    .then(function (json){
      end = new Date();
      time = end - start;
      this.performance();
      console.log('ShippingBar:');
      console.log(json);
      this.jsonObject = json;
      // change the text and the style and functions
      var cartTotalPrice = document.querySelector('.pdd-cart-total-price').innerHTML;
      this.buildTopBarHtml(this.jsonObject, cartTotalPrice);
    });
  
  function fetchCart() {
    fetch('/cart.js', {
         method: 'GET',
      })
      .then(response => {
        return response.json();
      })
      .then(json => {
        console.log(json);
        that.buildTopBarHtml(this.jsonObject, json.total_price);
      })
      .catch((error) => {
        console.error('Error:', error);
      });
  }
  
  function performance() {
    fetch(url+'/pdd/performance?shop='+shopDomain+"&time="+time+"&type="+requestType+"&path="+requestPath+"&timezone="+timeZone)
    .then(function(response) {
      return response.json();
    })
    .then(function (json) {
      console.log(json);
    })
  }
  
  function buildTopBarHtml(json, cartTotalPrice) {
    console.log('buildTopBarHtml total_price='+cartTotalPrice);
    var body = document.querySelector('body');
    var oldTopBars = document.querySelector('.top-bars');
    var oldBottomBars = document.querySelector('.bottom-bars');
    if(oldTopBars) {
      oldTopBars.remove();
    }
    if(oldBottomBars) {
      oldBottomBars.remove();
    }
    var topBars = document.createElement('div');
    topBars.classList.add('top-bars');
    var bottomBars = document.createElement('div');
    bottomBars.classList.add('bottom-bars');
    for(var i=0;i<json.length;i++) {
      console.log(i);
      pddWrap = document.createElement('div');
      pddWrap.classList.add('pdd-wrap');
      pddWrap.id = 'pdd-wrap-' + i;
      pddBgImageWrap = document.createElement('div');
      pddBgImageWrap.classList.add('pdd-bg-image-wrap');
      pddBgImage = document.createElement('img');
      pddBgImage.src = json[i].bg_image;
      pddBgImage.classList.add('pdd-bg-image');
      pddBgImageWrap.append(pddBgImage);
      pddWrap.append(pddBgImageWrap);
      
      pddShippingBar = document.createElement('div');
      pddShippingBar.classList.add('pdd-shipping-bar');
      pddShippingBar.append(document.createElement('div'));
      pddShippingBar.dataset.id = json[i].id;
      pddMessage = document.createElement('div');
      pddMessage.classList.add('pdd-message');
      pddMessage.id = "pdd-message-" + i;
      pddMsg1 = document.createElement('div');
      pddMsg1.classList.add('pdd-msg-1');
      pddMsg2 = document.createElement('div');
      pddMsg2.classList.add('pdd-msg-2');
      pddMsgGoal = document.createElement('div');
      pddMsgGoal.classList.add('pdd-msg-goal');
      
      // set msg style
      pddMsg1.style.color = json[i].text_color;
      pddMsg2.style.color = json[i].text_color;
      pddMsgGoal.style.color = json[i].shipping_goal_text_color;
      // build msg content
      var shippingPrice = 0;
      var ctp = cartTotalPrice/100;
      // rate controll the currency conversion
      if(json[i].rate) {
          shippingPrice = this.FormatNumber(json[i].shipping_goal * json[i].rate, 0);
      }else{
          shippingPrice = json[i].shipping_goal;
      }
      if(json[i].shipping_goal != 0) {
        if(ctp==0) {
            pddMsg1.innerHTML = json[i].init_message_1; 
            pddMsg2.innerHTML = json[i].init_message_2;
            pddMsgGoal.innerHTML = "&nbsp;"+cartCurrency + "&nbsp;" + shippingPrice + "&nbsp;";
        }else if(ctp<shippingPrice) {
            pddMsg1.innerHTML = json[i].progress_message_1; 
            pddMsg2.innerHTML = json[i].progress_message_2; 
            pddMsgGoal.innerHTML = "&nbsp;"+cartCurrency + "&nbsp;" + Number(shippingPrice - ctp)+"&nbsp;";
        }else{
            pddMsg1.innerHTML = json[i].achieved_message_1; 
            pddMsg2.innerHTML = json[i].achieved_message_2;
            pddMsgGoal.innerHTML = '';
        }
      }else{
            pddMsg1.innerHTML = json[i].achieved_message_1; 
            pddMsg2.innerHTML = json[i].achieved_message_2;
            pddMsgGoal.innerHTML = '';
      }
      
      pddMessage.append(pddMsg1);
      pddMessage.append(pddMsgGoal);
      pddMessage.append(pddMsg2);
      pddShippingBar.append(pddMessage);
      pddWrap.append(pddShippingBar);
      
      pddCloseBtn = document.createElement('div');
      pddCloseBtn.innerHTML = '<svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
      pddCloseBtn.classList.add('pdd-close-btn');
      pddShippingBar.append(pddCloseBtn);
      
      // choose the position
      if(json[i].display_position == 'TOP' && this.getCookie('free_shipping_bar_by_pb_'+json[i].id) != '1') {
      	topBars.append(pddWrap);
      }else if(json[i].display_position == 'BOTTOM' && this.getCookie('free_shipping_bar_by_pb_'+json[i].id) != '1'){
      	bottomBars.append(pddWrap);
      }
      
      // set the close btn 
      if(json[i].add_close_btn) {
        pddCloseBtn.id = 'pdd-close-btn-'+i;
        pddCloseBtn.style.opacity = 1;
        pddCloseBtn.dataset.show = 1;
        pddCloseBtn.dataset.barId = json[i].id
        pddCloseBtn.dataset.expires = json[i].expires_days;
        pddCloseBtn.style.color = json[i].close_btn_color;
        pddCloseBtn.style.cursor = 'pointer';
      }else{
        pddCloseBtn.id = 'pdd-close-btn-'+i;
        pddCloseBtn.dataset.show = 0;
      }
      
      // message link
      if(json[i].add_link){
        pddMessage.style.cursor = 'pointer';
        pddMessage.dataset.link = json[i].link;
        pddMessage.addEventListener('click', function(e) {
          console.log(this.dataset.link);
          window.location = this.dataset.link;
        })
      }
      
      // set bg image
      if(json[i].bg_image){
        pddBgImage.style.opacity = json[i].bg_opacity/100;
        pddShippingBar.style.background = 'transparent';
      }else{
        pddShippingBar.style.backgroundColor = this.colorRgb(json[i].bg_color, json[i].bg_opacity/100);
      } 
    }
    
    
    // add to the body
    body.prepend(topBars);
    body.prepend(bottomBars);

    // set the listener
    btns = document.querySelectorAll('.pdd-close-btn');
    console.log('btns count ='+btns.length);
    var that = this;
    btns.forEach((btn) => {
      console.log('btn for loop '+btn.id);
      var id = btn.id;
      let i = id.substring(id.length-1);
      if(btn.dataset.show == 1 && that.getCookie('free_shipping_bar_by_pb_'+btn.dataset.barId) != '1') {
        btn.addEventListener('click', function() {
          console.log('btn '+id+' clicked, i='+i);
          wrap = document.getElementById('pdd-wrap-'+i);
          wrap.style.display = 'none';
          console.log(wrap);
          // set cookie
          that.setCookie('free_shipping_bar_by_pb_'+btn.dataset.barId, '1', btn.dataset.expires);
        })
      }
    })
  }
  
  function setCookie(cname,cvalue,exdays)
  {
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
  }
  
  function getCookie(cname)
  {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) 
    {
      var c = ca[i].trim();
      if (c.indexOf(name)==0) return c.substring(name.length,c.length);
    }
    return "";
  }
  
  function FormatNumber(srcStr,nAfterDot){
　　var srcStr,nAfterDot;
　　var resultStr,nTen;
　　srcStr = ""+srcStr+"";
　　strLen = srcStr.length;
　　dotPos = srcStr.indexOf(".",0);
　　if (dotPos == -1){
　　　　resultStr = srcStr+".";
　　　　for (i=0;i<nAfterDot;i++){
　　　　　　resultStr = resultStr+"0";
　　　　}
　　　　return resultStr;
　　}
　　else{
　　　　if ((strLen - dotPos - 1) >= nAfterDot){
　　　　　　nAfter = dotPos + nAfterDot + 1;
　　　　　　nTen =1;
　　　　　　for(j=0;j<nAfterDot;j++){
　　　　　　　　nTen = nTen*10;
　　　　　　}
　　　　　　resultStr = Math.round(parseFloat(srcStr)*nTen)/nTen;
　　　　　　return resultStr;
　　　　}
　　　　else{
　　　　　　resultStr = srcStr;
　　　　　　for (i=0;i<(nAfterDot - strLen + dotPos + 1);i++){
　　　　　　　　resultStr = resultStr+"0";
　　　　　　}
　　　　　　return resultStr;
　　　　}
　　}
  }
  
  function colorRgb(data, opacity) {
    // 16进制颜色值的正则 
    let reg = /^#([0-9a-fA-f]{3}|[0-9a-fA-f]{6})$/;
    // 把颜色值变成小写 
    let color = data.toLowerCase();
    if (reg.test(color)) {
        // 如果只有三位的值，需变成六位，如：#fff => #ffffff 
        if (color.length === 4) {
            let colorNew = "#";
            for (let i = 1; i < 4; i += 1) {
                colorNew += color.slice(i, i + 1).concat(color.slice(i, i + 1));
            }
            color = colorNew;
        }
        // 处理六位的颜色值，转为RGB 
        let colorChange = [];
        for (let i = 1; i < 7; i += 2) {
            colorChange.push(parseInt("0x" + color.slice(i, i + 2)));
        }
        return "rgba(" + colorChange.join(",") +","+ opacity+ ")";
    } else { return color; }
  }
</script>
 