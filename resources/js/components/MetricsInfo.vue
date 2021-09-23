<template>
    <div class="col-span-6 md:col-span-3">
        <div class="col-span-6 text-gray-700 text-xl font-light">Performance tracking</div>
        <div class="mt-4 col-span-6 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="grid grid-cols-2">
                <div class="col-span-1 px-5 py-5 flex flex-col items-start rounded rounded-r-none border border-l-0 border-t-0 border-b-0 border-r-2 border-gray-100">
                    <div class="text-gray-900 text-lg font-medium">Traffic Past Hour</div>
                    <div class="mt-2 text-indigo-500 text-2xl font-medium">
                        {{ traffic }}
                        <span class="text-lg font-normal">hit</span>
                    </div>
                </div>
                <div class="col-span-1 px-5 py-5 flex flex-col items-start rounded rounded-l-none border-l-1 border-gray-500">
                    <div class="text-gray-900 text-lg">Response Avg Timing Past Hour</div>
                    <div class="mt-2 text-indigo-500 text-2xl font-medium">
                        {{ Math.round(avg_timing) }}
                        <span class="text-lg font-normal">ms</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapState } from "vuex";
export default {
    data() {
        return {
            interval: null,
            tempCookie: "",
        };
    },
    computed: {
        ...mapState({
            traffic: (state) => state.anti.traffic,
            avg_timing: (state) => state.anti.avg_timing,
        }),
    },
    mounted() {
        setTimeout(() => {
            this.getTraffic();
            this.getAvgTiming();
        }, 2000);
    },
    methods: {
        getTraffic() {
            axios.get("/metrics_traffic_past_hour").then((res) => {
                this.$store.commit("anti/SET_TRAFFIC", { traffic: res.data });
            });
        },
        getAvgTiming() {
            axios.get("/metrics_avg_timing_past_hour").then((res) => {
                this.$store.commit("anti/SET_AVG_TIMING", { avg_timing: res.data });
            });
        },
    },
};

</script>
