<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Buchungsvorgang {{ trainingDate }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                     <FieldSelection @input="this.trainingDate = $event.target.value" message="Möchtest du jetzt trainieren oder später?" :selections="[{title: 'Jetzt', value: 'now', subtitle: 'Buche dich sofort ein und fang an zu trainieren.'}, {'title': 'Anderer Zeitpunkt', subtitle: 'Buche dich zu einem späteren Zeitpunkt ein.', value: 'date' }]"></FieldSelection>
                    <FieldSelection @input="this.exactTrainingDate = $event.target.value" v-show="trainingDate === 'date'"  message="Wann möchtest du trainieren?" :selections="[{title: '1 Stunde', value: '1'}, {'title': '2 Stunden', value: '2' }, {'title': '3 Stunden', value: '3' }]"></FieldSelection>
                    <FieldSelection @input="this.trainingsDuration = $event.target.value" v-show="(trainingDate === 'now') || (trainingDate === 'date' && exactTrainingDate !== null)" message="Wie lange möchtest du trainieren?" :selections="[{title: '1 Stunde', value: '1'}, {'title': '2 Stunden', value: '2' }, {'title': '3 Stunden', value: '3' }]"></FieldSelection>
                </div>
                <Link as="button" :class="{'bg-gray-300': !this.formReady}" :disabled="!this.formReady" class="mt-2 w-full bg-indigo-600 border disabled:bg-gray-300 border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Fortfahren</Link>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import Datepicker from 'vue3-date-time-picker';
    import 'vue3-date-time-picker/dist/main.css'
    import FieldSelection from "../Custom/FieldSelection";

    export default defineComponent({
        data() {
          return {
              trainingDate: null,
              trainingsDuration: null,
              exactTrainingDate: null
          }
        },
        computed: {
            formReady() {
                if (this.trainingDate === 'now' && this.trainingsDuration !== null) {
                    return true
                }

                if (this.trainingDate === 'date' && this.exactTrainingDate !== null && this.trainingsDuration !== null) {
                    return true
                }
            }
        },
        components: {
            FieldSelection,
            AppLayout,
            Datepicker,
            Welcome,
        },
    })
</script>
