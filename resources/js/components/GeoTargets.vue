<template>
  <div>
    <div class="grid grid-cols-4 gap-4">
      <div
        class="col-span-1 rounded bg-gray-100 text-gray-800 shadow-sm text-sm p-2 flex justify-between items-center"
        v-for="(currency, index) in targets"
        :key="index"
      >
        <img :src="getCurrencyImage(currency)" class="w-6" alt />
        <div class="ml-1">{{currency}}</div>
        <div class="text-gray-500" @click="remove(index)">
          <svg
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </div>
      </div>
    </div>
    <div class="relative">
      <div
        @click="show_popup = true"
        class="mt-4 rounded bg-green-600 text-white text-sm py-2 text-center cursor-pointer hover:bg-green-700"
      >Add Geo Target</div>
      <div
        class="absolute top-0 left-0 w-full flex flex-col border border-gray-300 bg-white overflow-y-scroll"
        style="z-index:99999;height:200px;"
        v-if="show_popup"
        v-on-clickaway="hide"
      >
        <div
          @click="add(currency.currency)"
          class="flex items-center px-4 py-2 border-b-2"
          v-for="(currency, index) in currencies"
          :key="index"
        >
          <img class="h-6" :src="currency.image" alt />
          <div class="flex-1 ml-1 text-gray-800">{{currency.currency_name}}</div>
          <div class="ml-1 text-gray-800">{{currency.currency}}({{currency.currency_symbol}})</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import { mixin as clickaway } from "vue-clickaway";
export default {
  props: ["targets"],
  mixins: [clickaway],
  data() {
    return {
      show_popup: false
    };
  },
  computed: {
    ...mapState({
      user: state => state.anti.user,
      currencies: state => state.anti.currencies
    })
  },
  methods: {
    getCurrencyImage(currency) {
      var c = this.currencies.find(c => c.currency === currency);
      if (c) {
        return c.image;
      }
    },
    add(currency) {
      console.log("add geo target");
      var find = this.targets.find(g => g === currency);
      if (find) {
        this.show_popup = false;
        return;
      }
      var list = this.targets.concat(currency);
      this.show_popup = false;
      this.$emit("update:targets", list);
    },
    remove(index) {
      console.log("remove geo target");
      var list = this.targets;
      if (index > -1) {
        list.splice(index, 1);
        this.$emit("update:targets", list);
      }
    },
    hide() {
      this.show_popup = false;
    }
  }
};
</script>
