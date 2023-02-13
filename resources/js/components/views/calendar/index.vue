<template>

    <div class="row m-0">
        <div class="col-md-9">
            <div class="row h-100" >
                <div class="w-100">
                    <div id="calendar">
                        <calendar-view
                            :show-date="showDate"
                            locale="pt"
                            :startingDayOfWeek="this.iniWeak"
                            weekdayNameFormat="long"
                            :events="events"
                            @click-event="onClickEvent"
                            class="theme-default">
                            <calendar-view-header
                                slot="header"
                                slot-scope="t"
                                :header-props="t.headerProps"
                                @input="setShowDate" />
                        </calendar-view>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-4">
            <div class="row h-100" >
                <div class="card-block w-100 p-3 border-left aside-panel">
                    <div class="">
                        <h6 class="text-black-50">Selecione uma tarefa no calendario para ver os detalhes aqui.</h6>
                        <hr class="m-0 mb-2">
                    </div>
                    <div class="options" v-if="selected_event != null">
                        <h5 class="text-semibold no-margin text-wrap fw-500">
                            <a :href="selected_event ? selected_event.originalEvent.url : null">{{ selected_event ? selected_event.title : null}}</a>
                        </h5>
                        <div class="mt-2">
                            <h6 class="">
                                <span class="fw-600">Tipo de Tarefa:</span> {{ selected_event ? selected_event.originalEvent.tracker : null}}
                            </h6>
                            <div class="">
                                <span class="fw-600">Data de Inicio:</span> {{ selected_event ? selected_event.originalEvent.startDate : null}}
                            </div>
                            <div class="">
                                <span class="fw-600">Data de Fim:</span> {{ selected_event ? selected_event.originalEvent.due_date : null}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue'
    import { CalendarView, CalendarViewHeader } from "vue-simple-calendar"

    require("vue-simple-calendar/static/css/default.css")
    require("vue-simple-calendar/static/css/holidays-us.css")

    export default Vue.extend({
        props:[
            'events_data'
            ],
        data: function() {
			return {
                // showDate: new Date('10/15/2018'),
                showDate: new Date(),
                iniWeak: 1,
                events: this.events_data,
                selected_event: null
                }
		},
		components: {
			CalendarView,
			CalendarViewHeader,
		},
		methods: {
			setShowDate(d) {
                this.showDate = d;
                this.calendar_data
            },

            onClickEvent(event, e){
                // console.log(event.originalEvent)
                this.selected_event = event;
            }
		}
    })
</script>

<style scoped>
#calendar {
		font-family: 'Avenir', Helvetica, Arial, sans-serif;
		color: #2c3e50;
		height: 67vh;
		margin-left: auto;
		margin-right: auto;
	}
.theme-default .cv-event{
    cursor: pointer !important;
}

</style>
