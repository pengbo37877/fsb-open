<template>
  <div class="text-sm flex flex-col space-y-2">
    <!-- init message -->
    <div
      :class="`flex relative rounded`"
      :style="{background:fsb.bg_image ? 'transparent' : fsb.bg_color, height:fsb.height, opacity: fsb.bg_opacity / 100}"
    >
      <!-- background image -->
      <div class="absolute rounded w-full h-10 top-0 left-0 z-0" v-if="fsb.bg_image">
        <img
          :style="{opacity: fsb.bg_opacity / 100, height:fsb.height}"
          class="object-cover rounded w-full"
          :src="fsb.bg_image"
          alt
        />
      </div>
      <!-- message -->
      <div
        class="flex items-center relative justify-center rounded leading-8 py-1 w-full z-10"
        :style="{height: fsb.height, fontSize: fsb.font_size}"
      >
        <div :style="{color: fsb.text_color, fontFamily:fsb.font+''}">{{ fsb.init_message_1 }}</div>
        <div class="px-2" :style="{color: fsb.shipping_goal_text_color, fontFamily:fsb.font+''}">
          {{ fsb.shipping_goal_currency_symbol
          }}{{ fsb.shipping_goal }}
        </div>
        <div :style="{color: fsb.text_color, fontFamily:fsb.font+''}">{{ fsb.init_message_2 }}</div>
        <div
          class="absolute top-0 right-3 w-4 h-4 flex items-center"
          :style="{color: fsb.close_btn_color, height: fsb.height, lineHeight: fsb.height}"
          v-if="fsb.add_close_btn"
        >
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
    <!-- progress message -->
    <div
      :class="`flex relative rounded`"
      :style="{background: fsb.bg_image ? 'transparent' : fsb.bg_color, height: fsb.height, opacity: fsb.bg_opacity / 100}"
    >
      <div class="absolute rounded w-full h-10 top-0 left-0 z-0" v-if="fsb.bg_image">
        <img
          :style="{opacity: fsb.bg_opacity / 100, height: fsb.height}"
          class="object-cover rounded w-full"
          :src="fsb.bg_image"
          alt
        />
      </div>
      <div
        class="flex items-center relative justify-center rounded leading-8 py-1 w-full z-10"
        :style="{height: fsb.height, fontSize: fsb.font_size}"
      >
        <div :style="{color: fsb.text_color, fontFamily:fsb.font+''}">{{ fsb.progress_message_1 }}</div>
        <div class="px-2" :style="{color: fsb.shipping_goal_text_color, fontFamily:fsb.font+''}">
          {{ fsb.shipping_goal_currency_symbol
          }}{{ fsb.shipping_goal }}
        </div>
        <div :style="{color: fsb.text_color, fontFamily:fsb.font+''}">{{ fsb.progress_message_2 }}</div>
        <div
          class="absolute top-0 right-3 w-4 h-4 flex items-center"
          :style="{color: fsb.close_btn_color, height: fsb.height, lineHeight: fsb.height}"
          v-if="fsb.add_close_btn"
        >
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
    <!-- achieved message -->
    <div
      :class="`flex relative rounded`"
      :style="{background: fsb.bg_image ? 'transparent' : fsb.bg_color, height: fsb.height, opacity: fsb.bg_opacity / 100}"
    >
      <div
        class="absolute rounded w-full top-0 left-0 z-0"
        v-if="fsb.bg_image"
        :style="{height: fsb.height}"
      >
        <img
          :style="{opacity: fsb.bg_opacity / 100, height: fsb.height}"
          class="object-cover rounded w-full"
          :src="fsb.bg_image"
          alt
        />
      </div>
      <div
        class="flex items-center relative justify-center rounded leading-8 py-1 w-full z-10"
        :style="{height:fsb.height, fontSize: fsb.font_size}"
      >
        <div :style="{color: fsb.text_color, fontFamily:fsb.font+''}">{{ fsb.achieved_message_1 }}</div>
        <div :style="{color: fsb.text_color, fontFamily:fsb.font+''}">{{ fsb.achieved_message_2 }}</div>
        <div
          class="absolute top-0 right-3 w-4 h-4 flex items-center"
          :style="{color: fsb.close_btn_color, height: fsb.height, lineHeight: fsb.height}"
          v-if="fsb.add_close_btn"
        >
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
  </div>
</template>

<script>
export default {
  props: ["fsb"],
  mounted() {
    console.log("Mounted Bar Item");
    console.log(this.fsb);
  }
};
</script>
