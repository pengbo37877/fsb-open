<template>
  <div>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex content-between">
          <div class="flex flex-1 justify-start">
            <h1
              class="
                text-3xl
                font-bold
                text-gray-900
                overflow-hidden
                whitespace-nowrap
              "
            >
              {{ form.id ? "Edit " : "Create" }}
            </h1>
          </div>
          <div class="flex justify-end">
            <a
              href="/fsb"
              class="
                px-4
                py-2
                cursor-pointer
                bg-gray-700
                rounded-md
                text-sm
                font-medium
                hover:bg-gray-900
                text-white
              "
              aria-current="page"
            >
              Go back to preview
            </a>
          </div>
        </div>
      </div>
    </header>
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Replace with your content -->
        <div>
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                  Content configuration
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                  This information will be displayed publicly so be careful what
                  you share.
                </p>
              </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
              <div>
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                  <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <div class="grid grid-cols-2">
                      <div class="col-span-6 lg:col-span-1">
                        <label
                          for="name"
                          class="block text-sm font-medium text-gray-700"
                          >Name</label
                        >
                        <input
                          type="text"
                          name="name"
                          id="name"
                          autocomplete="name"
                          placeholder="Free shipping bar"
                          v-model="form.name"
                          class="
                            mt-1
                            focus:ring-indigo-500
                            focus:border-indigo-500
                            block
                            w-full
                            shadow-sm
                            sm:text-sm
                            border-gray-300
                            rounded-md
                          "
                        />
                        <p class="mt-2 text-sm text-gray-500">
                          For your own internal reference. Only you can see it.
                        </p>
                        <p
                          class="text-red-500 text-sm mt-2"
                          v-if="errors.name && form.name.length < 1"
                        >
                          {{ errors.name[0] }}
                        </p>
                      </div>
                    </div>

                    <div class="grid grid-cols-3">
                      <div>
                        <label
                          for="status"
                          class="block text-sm font-medium text-gray-700"
                          >Status</label
                        >
                        <div class="flex">
                          <select
                            id="status"
                            name="status"
                            autocomplete="status"
                            class="
                              mt-1
                              block
                              w-full
                              py-2
                              px-3
                              border border-gray-300
                              bg-white
                              rounded-md
                              shadow-sm
                              focus:outline-none
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              sm:text-sm
                            "
                            v-model="form.active"
                          >
                            <option :value="1">Active</option>
                            <option :value="0">Draft</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="grid grid-cols-2">
                      <div class="col-span-6 lg:col-span-1">
                        <label
                          for="shipping-goal"
                          class="block text-sm font-medium text-gray-700"
                          >Free shipping goal</label
                        >
                        <div class="mt-1 relative rounded-md shadow-sm">
                          <div
                            class="
                              absolute
                              inset-y-0
                              left-0
                              pl-3
                              flex
                              items-center
                              pointer-events-none
                            "
                          >
                            <span class="text-gray-500 sm:text-sm">
                              {{ user.money_format_symbol }}
                            </span>
                          </div>
                          <input
                            type="text"
                            name="shipping-goal"
                            id="shipping-goal"
                            class="
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              pl-7
                              pr-12
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                            placeholder="0.00"
                            v-model="form.shipping_goal"
                          />
                          <div
                            class="absolute inset-y-0 right-0 flex items-center"
                          >
                            <label for="currency" class="sr-only"
                              >Currency</label
                            >
                            <select
                              id="currency"
                              name="currency"
                              v-model="form.shipping_goal_currency"
                              class="
                                focus:ring-indigo-500
                                focus:border-indigo-500
                                h-full
                                py-0
                                pl-2
                                pr-7
                                border-transparent
                                bg-transparent
                                text-gray-500
                                sm:text-sm
                                rounded-md
                              "
                            >
                              <option
                                v-for="(currency, index) in JSON.parse(
                                  user.enabled_presentment_currencies
                                )"
                                :key="index"
                                :value="currency"
                              >
                                {{ currency }}
                              </option>
                            </select>
                          </div>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          If no minimum order value is required, please set goal
                          to 0.
                        </p>
                        <p
                          class="text-red-500 text-sm mt-2"
                          v-if="
                            errors.shipping_goal && !isNaN(form.shipping_goal)
                          "
                        >
                          {{ errors.shipping_goal[0] }}
                        </p>
                        <p
                          class="text-red-500 text-sm mt-2"
                          v-if="errors.shipping_goal_currency"
                        >
                          {{ errors.shipping_goal_currency[0] }}
                        </p>
                      </div>
                    </div>

                    <div class="col-span-3">
                      <div>
                        <label
                          for="init-message-1"
                          class="block text-sm font-medium text-gray-700"
                          >Initial Message</label
                        >
                        <div class="flex">
                          <input
                            type="text"
                            name="init-message-1"
                            id="init-message-1"
                            autocomplete="init-message-1"
                            v-model="form.init_message_1"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                          <div
                            class="
                              flex
                              content-center
                              items-center
                              mx-5
                              leading-relaxed
                            "
                          >
                            {{ user.money_format_symbol
                            }}{{ form.shipping_goal }}
                          </div>
                          <input
                            type="text"
                            name="init-message-2"
                            id="init-message-2"
                            autocomplete="init-message-2"
                            v-model="form.init_message_2"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          Display when cart is empty.
                        </p>
                      </div>
                    </div>

                    <div class="col-span-3">
                      <div>
                        <label
                          for="progress-message-1"
                          class="block text-sm font-medium text-gray-700"
                          >Progress Message</label
                        >
                        <div class="flex">
                          <input
                            type="text"
                            name="progress-message-1"
                            id="progress-message-1"
                            autocomplete="progress-message-1"
                            v-model="form.progress_message_1"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                          <div
                            class="
                              flex
                              content-center
                              items-center
                              mx-5
                              leading-relaxed
                            "
                          >
                            {{ user.money_format_symbol
                            }}{{ form.shipping_goal }}
                          </div>
                          <input
                            type="text"
                            name="progress-message-2"
                            id="progress-message-2"
                            autocomplete="progress-message-2"
                            v-model="form.progress_message_2"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          Display when cart is less than the goal.
                        </p>
                      </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                      <div class="col-span-6 lg:col-span-1">
                        <label
                          for="progress-message-1"
                          class="block text-sm font-medium text-gray-700"
                          >Goal Achieved Message</label
                        >
                        <div class="flex">
                          <input
                            type="text"
                            name="achieved-message-1"
                            id="achieved-message-1"
                            autocomplete="achieved-message-1"
                            v-model="form.achieved_message_1"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          Display when cart is greater than the goal.
                        </p>
                      </div>
                    </div>

                    <div class="grid grid-cols-3">
                      <div>
                        <label
                          for="display-position"
                          class="block text-sm font-medium text-gray-700"
                          >Display position on the page</label
                        >
                        <div class="flex">
                          <select
                            id="display-position"
                            name="display-position"
                            autocomplete="display-position"
                            class="
                              mt-1
                              block
                              w-full
                              py-2
                              px-3
                              border border-gray-300
                              bg-white
                              rounded-md
                              shadow-sm
                              focus:outline-none
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              sm:text-sm
                            "
                            v-model="form.display_position"
                          >
                            <option value="TOP">TOP</option>
                            <option value="BOTTOM">BOTTOM</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="grid grid-cols-3">
                      <div>
                        <label
                          for="add-link"
                          class="block text-sm font-medium text-gray-700"
                          >Add link to the bar (optional)</label
                        >
                        <div class="flex">
                          <select
                            id="add-link"
                            name="add-link"
                            autocomplete="add-link"
                            class="
                              mt-1
                              block
                              w-full
                              py-2
                              px-3
                              border border-gray-300
                              bg-white
                              rounded-md
                              shadow-sm
                              focus:outline-none
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              sm:text-sm
                            "
                            v-model="form.add_link"
                            @change="addLinkChange"
                          >
                            <option :value="0">NO</option>
                            <option :value="1">YES</option>
                          </select>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          The bar will be clickable after adding a link.
                        </p>
                      </div>
                    </div>

                    <div
                      class="grid grid-cols-3"
                      v-if="parseInt(form.add_link) === 1"
                    >
                      <div class="col-span-3">
                        <div>
                          <label
                            for="link"
                            class="block text-sm font-medium text-gray-700"
                            >Link URL</label
                          >
                          <input
                            type="text"
                            name="link"
                            id="link"
                            autocomplete="link"
                            placeholder="https://the-link"
                            v-model="form.link"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                          <p
                            class="text-red-500 text-sm mt-2"
                            v-if="errors.link"
                          >
                            {{ errors.link[0] }}
                          </p>
                        </div>
                      </div>
                    </div>

                    <div class="grid grid-cols-3">
                      <div>
                        <label
                          for="add-close-btn"
                          class="block text-sm font-medium text-gray-700"
                          >Include the close button (optional)</label
                        >
                        <select
                          id="add-close-btn"
                          name="add-close-btn"
                          autocomplete="add-close-btn"
                          v-model="form.add_close_btn"
                          @change="addCloseBtnChange"
                          class="
                            mt-1
                            block
                            w-full
                            py-2
                            px-3
                            border border-gray-300
                            bg-white
                            rounded-md
                            shadow-sm
                            focus:outline-none
                            focus:ring-indigo-500
                            focus:border-indigo-500
                            sm:text-sm
                          "
                        >
                          <option :value="0">NO</option>
                          <option :value="1">YES</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">
                          Place a 'x' button on the right of the bar, so users
                          can hide the bar manually.
                        </p>
                      </div>
                    </div>

                    <div
                      class="grid grid-cols-3"
                      v-if="parseInt(form.add_close_btn) === 1"
                    >
                      <div>
                        <label
                          for="expires-days"
                          class="block text-sm font-medium text-gray-700"
                          >Expires days</label
                        >
                        <input
                          type="number"
                          name="expires-days"
                          id="expires-days"
                          class="
                            mt-1
                            focus:ring-indigo-500
                            focus:border-indigo-500
                            block
                            w-full
                            pl-7
                            pr-12
                            sm:text-sm
                            border-gray-300
                            rounded-md
                          "
                          placeholder="1"
                          v-model="form.expires_days"
                        />
                        <p class="mt-2 text-sm text-gray-500">
                          user will see the bar after expires days.
                        </p>
                        <p
                          class="text-red-500 text-sm mt-2"
                          v-if="errors.expires_days"
                        >
                          {{ errors.expires_days[0] }}
                        </p>
                      </div>
                    </div>
                  </div>
                  <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <div class="flex items-center justify-end">
                      <div
                        v-if="created_success"
                        class="
                          flex-1
                          mr-4
                          text-gray-700 text-sm
                          justify-center
                          items-center
                        "
                      >
                        created!
                      </div>
                      <div
                        v-if="updated_content_success"
                        class="
                          flex-1
                          mr-4
                          text-gray-700 text-sm
                          justify-center
                          items-center
                        "
                      >
                        updated!
                      </div>
                      <button
                        @click.prevent="createFsb"
                        v-if="!bar.id"
                        class="
                          inline-flex
                          justify-center
                          py-2
                          px-4
                          border border-transparent
                          shadow-sm
                          text-sm
                          font-medium
                          rounded-md
                          text-white
                          bg-indigo-600
                          hover:bg-indigo-700
                          focus:outline-none
                          focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                        "
                      >
                        Save
                      </button>
                      <button
                        @click.prevent="updateFsbContent"
                        v-if="bar.id"
                        class="
                          inline-flex
                          justify-center
                          py-2
                          px-4
                          border border-transparent
                          shadow-sm
                          text-sm
                          font-medium
                          rounded-md
                          text-white
                          bg-indigo-600
                          hover:bg-indigo-700
                          focus:outline-none
                          focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                        "
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
          <div class="py-5">
            <div class="border-t border-gray-200"></div>
          </div>
        </div>

        <div class="mt-10 sm:mt-0">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                  Style Configuration
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                  Customize your shipping bar style.
                </p>
              </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
              <div>
                <div class="shadow overflow-hidden sm:rounded-md">
                  <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="bg-color"
                          class="block text-sm font-medium text-gray-700"
                          >Background Color</label
                        >
                        <div class="flex items-center">
                          <div class="mt-2">
                            <v-swatches
                              show-border
                              shapes="circles"
                              swatches="text-advanced"
                              v-model="form.bg_color"
                            ></v-swatches>
                          </div>
                          <input
                            type="text"
                            name="bg-color"
                            id="bg-color"
                            v-model="form.bg_color"
                            class="
                              mt-1
                              ml-2
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="text-color"
                          class="block text-sm font-medium text-gray-700"
                          >Text Color</label
                        >
                        <div class="flex items-center">
                          <div class="mt-2">
                            <v-swatches
                              show-border
                              shapes="circles"
                              swatches="text-advanced"
                              v-model="form.text_color"
                            ></v-swatches>
                          </div>
                          <input
                            type="text"
                            name="text-color"
                            id="text-color"
                            v-model="form.text_color"
                            class="
                              mt-1
                              ml-2
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="shipping-goal-text-color"
                          class="block text-sm font-medium text-gray-700"
                          >Shipping Goal Color</label
                        >
                        <div class="flex items-center">
                          <div class="mt-2">
                            <v-swatches
                              show-border
                              shapes="circles"
                              swatches="text-advanced"
                              v-model="form.shipping_goal_text_color"
                            ></v-swatches>
                          </div>
                          <input
                            type="text"
                            name="shipping-goal-text-color"
                            id="shipping-goal-text-color"
                            v-model="form.shipping_goal_text_color"
                            class="
                              mt-1
                              ml-2
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="close-btn-color"
                          class="block text-sm font-medium text-gray-700"
                          >Close Button Color</label
                        >
                        <div class="flex items-center">
                          <div class="mt-2">
                            <v-swatches
                              show-border
                              shapes="circles"
                              swatches="text-advanced"
                              v-model="form.close_btn_color"
                            ></v-swatches>
                          </div>
                          <input
                            type="text"
                            name="close-btn-color"
                            id="close-btn-color"
                            v-model="form.close_btn_color"
                            class="
                              mt-1
                              ml-2
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-full
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="bg-opacity"
                          class="block text-sm font-medium text-gray-700"
                          >Background Color Opacity</label
                        >
                        <div class="mt-2 mx-2">
                          <vue-slider v-model="form.bg_opacity"></vue-slider>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          The range is from 0 to 100, 0 = transparent and 1 =
                          solid
                        </p>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="bg-opacity"
                          class="block text-sm font-medium text-gray-700"
                          >Opacity value
                        </label>
                        <div>
                          <input
                            type="text"
                            name="bg-opacity"
                            id="bg-opacity"
                            v-model="form.bg_opacity"
                            class="
                              mt-1
                              focus:ring-indigo-500
                              focus:border-indigo-500
                              block
                              w-1/3
                              shadow-sm
                              sm:text-sm
                              border-gray-300
                              rounded-md
                            "
                          />
                        </div>
                      </div>

                      <div
                        class="col-span-6"
                        v-if="
                          user.plan_id == 2 ||
                          user.plan_id == 4 ||
                          user.plan_id == 5 ||
                          user.plan_id == 6 ||
                          user.shopify_grandfathered == 1
                        "
                      >
                        <fieldset>
                          <div>
                            <legend class="text-base font-medium text-gray-900">
                              Background Images
                            </legend>
                          </div>
                          <div class="mt-4 space-y-4">
                            <div class="flex items-center">
                              <input
                                id="push_everything"
                                name="bg_image"
                                type="radio"
                                v-model="form.bg_image"
                                value=""
                                class="
                                  focus:ring-indigo-500
                                  h-4
                                  w-4
                                  text-indigo-600
                                  border-gray-300
                                "
                              />
                              <label
                                for="push_everything"
                                class="ml-3 block w-full"
                              >
                                <div
                                  class="flex relative h-10 rounded"
                                  :style="{
                                    background: form.bg_color
                                      ? 'transparent'
                                      : form.bg_color,
                                  }"
                                >
                                  <div
                                    class="
                                      absolute
                                      rounded
                                      w-full
                                      h-10
                                      top-0
                                      left-0
                                      z-0
                                      flex
                                      items-center
                                      content-center
                                      text-white
                                      bg-gray-500
                                      px-5
                                    "
                                  >
                                    No Image
                                  </div>
                                </div>
                              </label>
                            </div>
                            <div class="flex items-center">
                              <input
                                id="push_everything"
                                name="bg_image"
                                type="radio"
                                v-model="form.bg_image"
                                value="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar023.jpeg"
                                class="
                                  focus:ring-indigo-500
                                  h-4
                                  w-4
                                  text-indigo-600
                                  border-gray-300
                                "
                              />
                              <label
                                for="push_everything"
                                class="ml-3 block w-full"
                              >
                                <div
                                  class="flex relative h-10 rounded"
                                  :style="{
                                    background: form.bg_color
                                      ? 'transparent'
                                      : form.bg_color,
                                  }"
                                >
                                  <div
                                    class="
                                      absolute
                                      rounded
                                      w-full
                                      h-10
                                      top-0
                                      left-0
                                      z-0
                                    "
                                  >
                                    <img
                                      :style="{
                                        opacity: getOpacity(),
                                      }"
                                      class="object-cover rounded w-full h-10"
                                      src="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar023.jpeg"
                                      alt=""
                                    />
                                  </div>
                                </div>
                              </label>
                            </div>
                            <div class="flex items-center">
                              <input
                                id="push_email"
                                name="bg_image"
                                type="radio"
                                v-model="form.bg_image"
                                value="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar020.png"
                                class="
                                  focus:ring-indigo-500
                                  h-4
                                  w-4
                                  text-indigo-600
                                  border-gray-300
                                "
                              />
                              <label for="push_email" class="ml-3 block w-full">
                                <div
                                  class="flex relative h-10 rounded"
                                  :style="{
                                    background: form.bg_color
                                      ? 'transparent'
                                      : form.bg_color,
                                  }"
                                >
                                  <div
                                    class="
                                      absolute
                                      rounded
                                      w-full
                                      h-10
                                      top-0
                                      left-0
                                      z-0
                                    "
                                  >
                                    <img
                                      :style="{
                                        opacity: getOpacity(),
                                      }"
                                      class="object-cover rounded w-full h-10"
                                      src="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar020.png"
                                      alt=""
                                    />
                                  </div>
                                </div>
                              </label>
                            </div>
                            <div class="flex items-center">
                              <input
                                id="push_nothing"
                                name="bg_image"
                                type="radio"
                                v-model="form.bg_image"
                                value="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar002.png"
                                class="
                                  focus:ring-indigo-500
                                  h-4
                                  w-4
                                  text-indigo-600
                                  border-gray-300
                                "
                              />
                              <label
                                for="push_nothing"
                                class="ml-3 block w-full"
                              >
                                <div
                                  class="flex relative h-10 rounded"
                                  :style="{
                                    background: form.bg_color
                                      ? 'transparent'
                                      : form.bg_color,
                                  }"
                                >
                                  <div
                                    class="
                                      absolute
                                      rounded
                                      w-full
                                      h-10
                                      top-0
                                      left-0
                                      z-0
                                    "
                                  >
                                    <img
                                      :style="{
                                        opacity: getOpacity(),
                                      }"
                                      class="object-cover rounded w-full h-10"
                                      src="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar002.png"
                                      alt=""
                                    />
                                  </div>
                                </div>
                              </label>
                            </div>
                            <!-- user images -->
                            <div
                              class="flex items-center"
                              v-for="image in display_images"
                              :key="image.uuid"
                            >
                              <input
                                id="push_nothing"
                                name="bg_image"
                                type="radio"
                                v-model="form.bg_image"
                                :value="image.url"
                                class="
                                  focus:ring-indigo-500
                                  h-4
                                  w-4
                                  text-indigo-600
                                  border-gray-300
                                "
                              />
                              <label
                                for="push_nothing"
                                class="ml-3 block w-full"
                              >
                                <div
                                  class="flex relative h-10 rounded"
                                  :style="{
                                    background: form.bg_color
                                      ? 'transparent'
                                      : form.bg_color,
                                  }"
                                >
                                  <div
                                    class="
                                      absolute
                                      rounded
                                      w-full
                                      h-10
                                      top-0
                                      left-0
                                      z-0
                                    "
                                  >
                                    <img
                                      :style="{
                                        opacity: getOpacity(),
                                      }"
                                      class="object-cover rounded w-full h-10"
                                      :src="image.url"
                                      alt=""
                                    />
                                  </div>
                                </div>
                              </label>
                            </div>
                          </div>
                        </fieldset>
                      </div>

                      <div
                        class="col-span-6"
                        v-if="
                          user.plan_id == 2 ||
                          user.plan_id == 4 ||
                          user.plan_id == 5 ||
                          user.plan_id == 6 ||
                          user.shopify_grandfathered == 1
                        "
                      >
                        <label class="block text-sm font-medium text-gray-700">
                          Upload your customize background image
                        </label>
                        <div
                          class="
                            mt-1
                            flex
                            justify-center
                            px-6
                            pt-5
                            pb-6
                            border-2 border-gray-300 border-dashed
                            rounded-md
                          "
                        >
                          <div class="space-y-1 text-center">
                            <svg
                              class="mx-auto h-12 w-12 text-gray-400"
                              stroke="currentColor"
                              fill="none"
                              viewBox="0 0 48 48"
                              aria-hidden="true"
                            >
                              <path
                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                              />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                              <label
                                for="file-upload"
                                class="
                                  relative
                                  cursor-pointer
                                  bg-white
                                  rounded-md
                                  font-medium
                                  text-indigo-600
                                  hover:text-indigo-500
                                  focus-within:outline-none
                                  focus-within:ring-2
                                  focus-within:ring-offset-2
                                  focus-within:ring-indigo-500
                                "
                              >
                                <span>Upload a file</span>
                                <input
                                  id="file-upload"
                                  name="file-upload"
                                  type="file"
                                  class="sr-only"
                                  @change="uploadFileChange"
                                />
                              </label>
                              <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                              PNG, JPG, GIF up to 10MB
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <div class="flex items-center justify-end">
                      <div
                        v-if="updated_style_success"
                        class="
                          flex-1
                          mr-4
                          text-gray-700 text-sm
                          justify-center
                          items-center
                        "
                      >
                        updated!
                      </div>

                      <button
                        v-if="bar.id"
                        @click.prevent="updateFsbStyle"
                        class="
                          inline-flex
                          justify-center
                          py-2
                          px-4
                          border border-transparent
                          shadow-sm
                          text-sm
                          font-medium
                          rounded-md
                          text-white
                          bg-indigo-600
                          hover:bg-indigo-700
                          focus:outline-none
                          focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                        "
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
          <div class="py-5">
            <div class="border-t border-gray-200"></div>
          </div>
        </div>

        <div class="mt-10 sm:mt-0">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                  Advanced Settings
                </h3>
                <p class="mt-1 text-sm text-gray-600">Advanced features.</p>
              </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
              <div action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                  <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <fieldset>
                      <legend class="text-base font-medium text-gray-900">
                        Page targeting
                      </legend>
                      <p class="text-sm text-gray-500">
                        Choose the page type you want display the bar.
                      </p>
                      <div class="grid grid-cols-3 mt-4">
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="404"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="404"
                              type="checkbox"
                              @change="showForm"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="404" class="font-medium text-gray-700"
                              >404</label
                            >
                          </div>
                        </div>
                        <div
                          class="mt-1 col-span-1 flex items-start sm:col-span-3"
                        >
                          <div class="flex items-center h-5">
                            <input
                              id="article"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="article"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="article"
                              class="font-medium text-gray-700"
                              >article</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="blog"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="blog"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="blog" class="font-medium text-gray-700"
                              >blog</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="cart"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="cart"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="cart" class="font-medium text-gray-700"
                              >cart</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="collection"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="collection"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="collection"
                              class="font-medium text-gray-700"
                              >collection</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="list-collections"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="list-collections"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="list-collections"
                              class="font-medium text-gray-700"
                              >list-collections</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-account"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/account"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-account"
                              class="font-medium text-gray-700"
                              >customers/account</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-activate-account"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/activate_account"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-activate-account"
                              class="font-medium text-gray-700"
                              >customers/activate_account</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-addresses"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/addresses"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-addresses"
                              class="font-medium text-gray-700"
                              >customers/addresses</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-login"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/login"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-login"
                              class="font-medium text-gray-700"
                              >customers/login</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-order"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/order"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-order"
                              class="font-medium text-gray-700"
                              >customers/order</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-register"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/register"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-register"
                              class="font-medium text-gray-700"
                              >customers/register</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="customers-reset-password"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="customers/reset_password"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="customers-reset-password"
                              class="font-medium text-gray-700"
                              >customers/reset_password</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="gift-card"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="gift_card"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="gift-card"
                              class="font-medium text-gray-700"
                              >gift_card</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="index"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="index"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="index" class="font-medium text-gray-700"
                              >index</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="page"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="page"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label for="page" class="font-medium text-gray-700"
                              >page</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="password"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="password"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="password"
                              class="font-medium text-gray-700"
                              >password</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="product"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="product"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="product"
                              class="font-medium text-gray-700"
                              >product</label
                            >
                          </div>
                        </div>
                        <div class="mt-1 col-span-3 flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="search"
                              name="page-targets"
                              v-model="form.page_targets"
                              value="search"
                              type="checkbox"
                              class="
                                focus:ring-indigo-500
                                h-4
                                w-4
                                text-indigo-600
                                border-gray-300
                                rounded
                              "
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="search"
                              class="font-medium text-gray-700"
                              >search</label
                            >
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <fieldset
                      v-if="
                        user.plan_id == 2 ||
                        user.plan_id == 4 ||
                        user.plan_id == 5 ||
                        user.plan_id == 6 ||
                        user.shopify_grandfathered == 1
                      "
                    >
                      <div>
                        <legend class="text-base font-medium text-gray-900">
                          Auto scheduling ({{
                            Intl.DateTimeFormat().resolvedOptions().timeZone
                          }})
                        </legend>
                        <p class="text-sm text-gray-500">
                          The bar will display in this time range.
                        </p>
                      </div>
                      <div class="mt-4">
                        <date-picker
                          v-model="form.date_range"
                          valueType="timestamp"
                          type="date"
                          range
                          placeholder="Select date range "
                        ></date-picker>
                      </div>
                    </fieldset>
                    <fieldset
                      v-if="
                        user.plan_id == 2 ||
                        user.plan_id == 4 ||
                        user.plan_id == 5 ||
                        user.plan_id == 6 ||
                        user.shopify_grandfathered == 1
                      "
                    >
                      <div>
                        <legend class="text-base font-medium text-gray-900">
                          Auto currency conversion
                        </legend>
                        <p class="text-sm text-gray-500">
                          The money will display as client local currency value.
                        </p>
                      </div>
                      <div class="mt-4 space-y-4">
                        <div class="flex items-center">
                          <input
                            id="currency-conversion-yes"
                            name="currency-conversion-yes"
                            type="radio"
                            v-model="form.currency_conversion"
                            :value="1"
                            class="
                              focus:ring-indigo-500
                              h-4
                              w-4
                              text-indigo-600
                              border-gray-300
                            "
                          />
                          <label
                            for="currency-conversion-yes"
                            class="ml-3 block text-sm font-medium text-gray-700"
                          >
                            YES
                          </label>
                        </div>
                        <div class="flex items-center">
                          <input
                            id="currency-conversion-no"
                            name="currency-conversion-no"
                            type="radio"
                            v-model="form.currency_conversion"
                            :value="0"
                            class="
                              focus:ring-indigo-500
                              h-4
                              w-4
                              text-indigo-600
                              border-gray-300
                            "
                          />
                          <label
                            for="currency-conversion-no"
                            class="ml-3 block text-sm font-medium text-gray-700"
                          >
                            NO
                          </label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div
                    class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                    v-if="form.id"
                  >
                    <div class="flex items-center justify-end">
                      <div
                        v-if="updated_content_success"
                        class="
                          flex-1
                          mr-4
                          text-gray-700 text-sm
                          justify-center
                          items-center
                        "
                      >
                        updated!
                      </div>
                      <button
                        type="submit"
                        @click.prevent="updateFsbContent"
                        class="
                          inline-flex
                          justify-center
                          py-2
                          px-4
                          border border-transparent
                          shadow-sm
                          text-sm
                          font-medium
                          rounded-md
                          text-white
                          bg-indigo-600
                          hover:bg-indigo-700
                          focus:outline-none
                          focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                        "
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- /End replace -->
      </div>
    </main>
  </div>
</template>

<script>
import VSwatches from "vue-swatches";
import "vue-swatches/dist/vue-swatches.css";
import VueSlider from "vue-slider-component";
import "vue-slider-component/theme/default.css";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";

export default {
  components: { VSwatches, VueSlider, DatePicker },
  props: ["user", "images", "shippingBar"],
  data() {
    return {
      form: {
        name: "",
        active: 1,
        shipping_goal: 0.0,
        shipping_goal_currency: this.user.currency,
        add_link: "0",
        link: "",
        display_position: "TOP",
        add_close_btn: "0",
        expires_days: 1,
        bg_color: "#ff7878",
        bg_opacity: 100,
        text_color: "#b9f5f1",
        shipping_goal_text_color: "#ffff00",
        close_btn_color: "#b9f5f1",
        page_targets: [
          "404",
          "article",
          "blog",
          "cart",
          "collection",
          "list-collections",
          "customers/account",
          "customers/activate_account",
          "customers/addresses",
          "customers/login",
          "customers/order",
          "customers/register",
          "customers/reset_password",
          "gift_card",
          "index",
          "page",
          "password",
          "product",
          "search",
        ],
        date_range: [],
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone,
        currency_conversion: "0",
      },
      created_success: false,
      updated_content_success: false,
      updated_style_success: false,
      errors: {},
      bar: {},
      display_images: [],

      isLoading: false,
      fullPage: true,
    };
  },
  computed: {},
  mounted() {
    console.log("Component mounted.");
    if (this.images) {
      this.display_images = this.images;
    }
    if (this.shippingBar) {
      console.log(this.shippingBar);
      console.log("targets type=" + typeof this.shippingBar.page_targets);
      // deep copy
      this.bar = JSON.parse(JSON.stringify(this.shippingBar));
      this.form = JSON.parse(JSON.stringify(this.shippingBar));
      // 重新设置时区
      this.bar.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
      this.form.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
      if (!this.shippingBar.page_targets) {
        this.bar.page_targets = [];
        this.form.page_targets = [];
      }
      //   else if (typeof this.shippingBar.page_targets === "string") {
      //     this.bar.page_targets = JSON.parse(this.shippingBar.page_targets);
      //     this.form.page_targets = JSON.parse(this.shippingBar.page_targets);
      //   } else if (typeof this.shippingBar.page_targets === "object") {
      //     this.bar.page_targets = this.shippingBar.page_targets;
      //     this.form.page_targets = this.shippingBar.page_targets;
      //   }
    }
  },
  created() {
    console.log("Component CreateFreeShippingBar.");
  },
  methods: {
    createFsb() {
      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel,
      });
      var that = this;
      axios
        .post("/fsb", this.form)
        .then((res) => {
          console.log(res.data);
          loader.hide();
          that.bar = res.data;
          that.created_success = true;
          setTimeout(() => {
            that.created_success = false;
          }, 3000);
        })
        .catch((error) => {
          loader.hide();
          if (error.response.status == 422) {
            that.errors = error.response.data.errors;
          }
        });
    },
    updateFsbContent() {
      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel,
      });
      var that = this;
      axios
        .put("/fsb/" + this.bar.id, this.form)
        .then((res) => {
          console.log(res.data);
          loader.hide();
          that.bar = res.data;
          that.updated_content_success = true;
          setTimeout(() => {
            that.updated_content_success = false;
          }, 3000);
        })
        .catch((error) => {
          loader.hide();
          if (error.response.status == 422) {
            that.errors = error.response.data.errors;
          }
        });
    },
    updateFsbStyle() {
      let loader = this.$loading.show({
        // Optional parameters
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel,
      });
      var that = this;
      axios
        .put("/fsb/" + this.bar.id, this.form)
        .then((res) => {
          console.log(res.data);
          that.bar = res.data;
          that.updated_style_success = true;
          loader.hide();
          setTimeout(() => {
            that.updated_style_success = false;
          }, 3000);
        })
        .catch((error) => {
          loader.hide();
          if (error.response.status == 422) {
            that.errors = error.response.data.errors;
          }
        });
    },
    getOpacity() {
      return this.form.bg_opacity / 100;
    },
    onCancel() {
      console.log("User cancelled the loader.");
    },
    showForm() {
      console.log(this.form);
    },
    uploadFileChange(e) {
      var that = this;
      console.log(e);
      var file = e.target.files[0];
      //   var token = document
      //     .querySelector("meta[name=csrf-token]")
      //     .getAttribute("content");
      //   Vapor.store(file, {
      //     visibility: "public-read",
      //     _token: token,
      //   }).then((response) => {
      //     console.log(response);
      //     axios
      //       .post("/upload", {
      //         uuid: response.uuid,
      //         key: response.key,
      //         bucket: response.bucket,
      //         url: response.url,
      //         name: file.name,
      //         content_type: file.type,
      //         _token: token,
      //       })
      //       .then((res) => {
      //         console.log(res);
      //         that.display_images.push(res.data);
      //         loader.hide();
      //       });
      //   });
      this.uploadVaporFile(file, {
        visibility: "public-read",
      });
    },

    async uploadVaporFile(file, options = {}) {
      var token = document
        .querySelector("meta[name=csrf-token]")
        .getAttribute("content");
      let loader = this.$loading.show({
        container: this.fullPage ? null : this.$refs.formContainer,
        canCancel: true,
        onCancel: this.onCancel,
      });

      const response = await axios.post(
        "/vapor/signed-storage-url",
        {
          bucket: options.bucket || "",
          content_type: options.contentType || file.type,
          expires: options.expires || "",
          visibility: options.visibility || "",
          _token: token,
        },
        {
          // baseURL: options.baseURL || null,
          headers: options.headers || { _token: token },
          ...options.options,
        }
      );

      let headers = response.data.headers;

      if ("Host" in headers) {
        delete headers.Host;
      }

      if (typeof options.progress === "undefined") {
        options.progress = () => {};
      }

      const cancelToken = options.cancelToken || "";

      await axios.put(response.data.url, file, {
        cancelToken: cancelToken,
        headers: headers,
        onUploadProgress: (progressEvent) => {
          options.progress(progressEvent.loaded / progressEvent.total);
        },
      });

      response.data.extension = file.name.split(".").pop();

      var that = this;
      await axios
        .post("/upload", {
          uuid: response.data.uuid,
          key: response.data.key,
          bucket: response.data.bucket,
          url: response.data.url,
          name: file.name,
          content_type: file.type,
          _token: token,
        })
        .then((res) => {
          console.log(res);
          that.display_images.push(res.data);
          loader.hide();
        });

      return response.data;
    },
    convertTZ(date, tzString) {
      return new Date(
        (typeof date === "string" ? new Date(date) : date)
          .toLocaleString("en-US", { timeZone: tzString })
          .getTime()
      );
    },
    addLinkChange(e) {
      console.log(e);
      console.log(this.form);
    },
    addCloseBtnChange(e) {
      console.log(e);
      console.log(this.form);
    },
  },
};
</script>
