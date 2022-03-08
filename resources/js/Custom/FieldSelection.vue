<template>
    <div class="mt-10 border-t border-gray-200 pt-10">
        <fieldset>
            <legend class="text-lg font-medium text-gray-900">{{ message }}</legend>

            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                <!--
                  Checked: "border-transparent", Not Checked: "border-gray-300"
                  Active: "ring-2 ring-indigo-500"
                -->

                <label @click="select(selection)" :class="{'ring-2 ring-indigo-500': currentSelection == selection.value }" v-for="selection of selections" class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none">
                    <input type="radio" name="delivery-method" :value="selection.value" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="delivery-method-0-description-0 delivery-method-0-description-1">
                    <div class="flex-1 flex">
                        <div class="flex flex-col">
                            <span id="delivery-method-0-label" class="block text-sm font-medium text-gray-900"> {{ selection.title }} </span>
                            <span v-show="selection.subtitle" id="delivery-method-0-description-0" class="mt-1 flex items-center text-sm text-gray-500"> 4–10 business days </span>
                            <span v-show="selection.price" id="delivery-method-0-description-1" class="mt-6 text-sm font-medium text-gray-900"> $5.00 </span>
                        </div>
                    </div>
                    <!--
                      Not Checked: "hidden"

                      Heroicon name: solid/check-circle
                    -->
                    <svg v-show="currentSelection == selection.value" class="h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <!--
                      Active: "border", Not Active: "border-2"
                      Checked: "border-indigo-500", Not Checked: "border-transparent"
                    -->
                    <div class="absolute -inset-px rounded-lg border-2 pointer-events-none" aria-hidden="true"></div>
                </label>
            </div>
        </fieldset>
    </div>
</template>

<script>
export default {
    name: "FieldSelection",
    data() {
        return {
            currentSelection: null
        }
    },
    methods: {
        select(obj) {
            this.currentSelection = obj.value
            this.$emit(obj.value)
        }
    },
    props: {
        message: {
            type: String
        },
        selections: {
            type: Array,
            // Object or array defaults must be returned from
            // a factory function
            default: () => {
                return [{ title: 'Sofort', value: 'now' }]
            }
        }
    }
}
</script>

<style scoped>

</style>
