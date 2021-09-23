<template>
  <div>
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit</h1>
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
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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

                    <div class="grid grid-cols-2">
                      <div class="col-span-6 lg:col-span-1">
                        <label
                          for="shipping-goal"
                          class="block text-sm font-medium text-gray-700"
                          >Free shipping goal</label
                        >
                        <div class="mt-1 relative rounded-md shadow-sm">
                          <div
                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                          >
                            <span class="text-gray-500 sm:text-sm">
                              {{ user.money_format_symbol }}
                            </span>
                          </div>
                          <input
                            type="text"
                            name="shipping-goal"
                            id="shipping-goal"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
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
                              class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-500 sm:text-sm rounded-md"
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
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                          />
                          <div
                            class="flex content-center items-center mx-5 leading-relaxed"
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
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                          />
                          <div
                            class="flex content-center items-center mx-5 leading-relaxed"
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
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                          >Display positon on the page</label
                        >
                        <div class="flex">
                          <select
                            id="display-position"
                            name="display-position"
                            autocomplete="display-position"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
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
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            v-model="form.add_link"
                          >
                            <option value="0">NO</option>
                            <option value="1">YES</option>
                          </select>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                          The bar will be clickable after adding a link.
                        </p>
                      </div>
                      <div class="col-span-2 ml-4" v-if="form.add_link">
                        <div>
                          <label
                            for="link"
                            class="block text-sm font-medium text-gray-700"
                            >The active URL</label
                          >
                          <input
                            type="text"
                            name="link"
                            id="link"
                            autocomplete="link"
                            placeholder="https://the-link"
                            v-model="form.link"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                          for="add-link"
                          class="block text-sm font-medium text-gray-700"
                          >Include the close button (optional)</label
                        >
                        <select
                          id="add-close-btn"
                          name="add-close-btn"
                          autocomplete="add-close-btn"
                          v-model="form.add_close_btn"
                          class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        >
                          <option value="0">NO</option>
                          <option value="1">YES</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">
                          Place a 'x' button on the right of the bar, so users
                          can hide the bar manually.
                        </p>
                      </div>
                      <div v-if="form.add_close_btn" class="col-span-2 ml-4">
                        <label
                          for="expires-days"
                          class="block text-sm font-medium text-gray-700"
                          >Expires days</label
                        >
                        <input
                          type="number"
                          name="expires-days"
                          id="expires-days"
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md"
                          placeholder="1"
                          v-model="form.expires_days"
                        />
                        <p class="mt-2 text-sm text-gray-500">
                          用户隐藏bar之后的n天，如果bar还是active状态，用户会再次看到.
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
                        class="flex-1 mr-4 text-gray-700 text-sm justify-center items-center"
                      >
                        created!
                      </div>
                      <div
                        v-if="updated_content_success"
                        class="flex-1 mr-4 text-gray-700 text-sm justify-center items-center"
                      >
                        updated!
                      </div>
                      <button
                        @click.prevent="createFsb"
                        v-if="!bar.id"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                      >
                        Save
                      </button>
                      <button
                        @click.prevent="updateFsbContent"
                        v-if="bar.id"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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
                            class="mt-1 ml-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                            class="mt-1 ml-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                            class="mt-1 ml-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                            class="mt-1 ml-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
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
                            name="close-btn-color"
                            id="close-btn-color"
                            v-model="form.bg_opacity"
                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-1/3 shadow-sm sm:text-sm border-gray-300 rounded-md"
                          />
                        </div>
                      </div>

                      <div class="col-span-6" v-if="user.plan_id == 2">
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
                                value="https://warm-hill-eiwfidlwac1y.vapor-farm-d1.com/image/bar023.jpeg"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
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
                                    class="absolute rounded w-full h-10 top-0 left-0 z-0"
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
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
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
                                    class="absolute rounded w-full h-10 top-0 left-0 z-0"
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
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
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
                                    class="absolute rounded w-full h-10 top-0 left-0 z-0"
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
                          </div>
                        </fieldset>
                      </div>

                      <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                        <label
                          for="city"
                          class="block text-sm font-medium text-gray-700"
                          >City</label
                        >
                        <input
                          type="text"
                          name="city"
                          id="city"
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                      </div>

                      <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                        <label
                          for="state"
                          class="block text-sm font-medium text-gray-700"
                          >State / Province</label
                        >
                        <input
                          type="text"
                          name="state"
                          id="state"
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                      </div>

                      <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                        <label
                          for="postal_code"
                          class="block text-sm font-medium text-gray-700"
                          >ZIP / Postal</label
                        >
                        <input
                          type="text"
                          name="postal_code"
                          id="postal_code"
                          autocomplete="postal-code"
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <div class="flex items-center justify-end">
                      <div
                        v-if="updated_style_success"
                        class="flex-1 mr-4 text-gray-700 text-sm justify-center items-center"
                      >
                        updated!
                      </div>

                      <button
                        v-if="bar.id"
                        @click.prevent="updateFsbStyle"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
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

        <div class="mt-10 sm:mt-0" v-if="bar.id">
          <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
              <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                  Advance Settings
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                  Pro plan shop can use these features.
                </p>
              </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
              <div action="#" method="POST">
                <div class="shadow overflow-hidden sm:rounded-md">
                  <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <fieldset>
                      <legend class="text-base font-medium text-gray-900">
                        By Email
                      </legend>
                      <div class="mt-4 space-y-4">
                        <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="comments"
                              name="comments"
                              type="checkbox"
                              class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="comments"
                              class="font-medium text-gray-700"
                              >Comments</label
                            >
                            <p class="text-gray-500">
                              Get notified when someones posts a comment on a
                              posting.
                            </p>
                          </div>
                        </div>
                        <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="candidates"
                              name="candidates"
                              type="checkbox"
                              class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="candidates"
                              class="font-medium text-gray-700"
                              >Candidates</label
                            >
                            <p class="text-gray-500">
                              Get notified when a candidate applies for a job.
                            </p>
                          </div>
                        </div>
                        <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input
                              id="offers"
                              name="offers"
                              type="checkbox"
                              class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                            />
                          </div>
                          <div class="ml-3 text-sm">
                            <label
                              for="offers"
                              class="font-medium text-gray-700"
                              >Offers</label
                            >
                            <p class="text-gray-500">
                              Get notified when a candidate accepts or rejects
                              an offer.
                            </p>
                          </div>
                        </div>
                      </div>
                    </fieldset>
                    <fieldset>
                      <div>
                        <legend class="text-base font-medium text-gray-900">
                          Push Notifications
                        </legend>
                        <p class="text-sm text-gray-500">
                          These are delivered via SMS to your mobile phone.
                        </p>
                      </div>
                      <div class="mt-4 space-y-4">
                        <div class="flex items-center">
                          <input
                            id="push_everything"
                            name="push_notifications"
                            type="radio"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                          />
                          <label
                            for="push_everything"
                            class="ml-3 block text-sm font-medium text-gray-700"
                          >
                            Everything
                          </label>
                        </div>
                        <div class="flex items-center">
                          <input
                            id="push_email"
                            name="push_notifications"
                            type="radio"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                          />
                          <label
                            for="push_email"
                            class="ml-3 block text-sm font-medium text-gray-700"
                          >
                            Same as email
                          </label>
                        </div>
                        <div class="flex items-center">
                          <input
                            id="push_nothing"
                            name="push_notifications"
                            type="radio"
                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300"
                          />
                          <label
                            for="push_nothing"
                            class="ml-3 block text-sm font-medium text-gray-700"
                          >
                            No push notifications
                          </label>
                        </div>
                      </div>
                    </fieldset>
                  </div>
                  <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <button
                      type="submit"
                      class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                      Save
                    </button>
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
export default {
  components: { VSwatches, VueSlider },
  props: ["user", "form"],
  data() {
    return {
      created_success: false,
      updated_content_success: false,
      updated_style_success: false,
      errors: {},
      bar: {},
    };
  },
  computed: {},
  mounted() {
    console.log("Component mounted.");
    console.log(this.form);
    this.bar = this.form;
  },
  created() {
    console.log("Component EditFreeShippingBar.");
  },
  methods: {
    createFsb() {
      var that = this;
      axios
        .post("/fsb", this.form)
        .then((res) => {
          console.log(res.data);
          that.bar = res.data;
          that.created_success = true;
          setTimeout(() => {
            that.created_success = false;
          }, 3000);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            that.errors = error.response.data.errors;
          }
        });
    },
    updateFsbContent() {
      var that = this;
      axios
        .put("/fsb/" + this.bar.id, this.form)
        .then((res) => {
          console.log(res.data);
          that.bar = res.data;
          that.updated_content_success = true;
          setTimeout(() => {
            that.updated_content_success = false;
          }, 3000);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            that.errors = error.response.data.errors;
          }
        });
    },
    updateFsbStyle() {
      var that = this;
      axios
        .put("/fsb/" + this.bar.id, this.form)
        .then((res) => {
          console.log(res.data);
          that.bar = res.data;
          that.updated_style_success = true;
          setTimeout(() => {
            that.updated_style_success = false;
          }, 3000);
        })
        .catch((error) => {
          if (error.response.status == 422) {
            that.errors = error.response.data.errors;
          }
        });
    },
    getOpacity() {
      return this.form.bg_opacity / 100;
    },
  },
};
</script>
