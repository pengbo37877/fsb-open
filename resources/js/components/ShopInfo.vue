<template>
    <div></div>
</template>
<script>
export default {
    data() {
        return {
            timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
            interval: null,
            tempCookie: "",
        };
    },
    mounted() {

        setTimeout(() => {
            this.getShop();
        }, 2000);
    },
    methods: {
        createFirstFsb() {
            axios.get("/create_first_fsb?timezone=" + this.timezone).then((res) => {
                console.log(res.data);
            });
        },
        getShop() {
            axios.get("/shop").then((res) => {
                console.log(res.data);
                this.createFirstFsb();
            });
        }
    },
};

</script>
