<template>
    <div ref="gantt"></div>
</template>

<script lang="ts">
    import Vue from 'vue'
    import 'dhtmlx-gantt'
    export default Vue.extend({
        name: 'gantt',
        props: ['project'],
        mounted: function () {
            gantt.config.xml_date = "%Y-%m-%d";
            gantt.config.autofit = true;
            gantt.config.click_drag = false;
            gantt.config.inherit_scale_class=true;
            gantt.config.smart_scales = true;
            gantt.config.start_on_monday = true;
            gantt.config.show_tasks_outside_timescale = false;
            // gantt.config.scale_offset_minimal = false;
            gantt.config.fit_tasks = true;
            // gantt.config.scale_height = 32;


            gantt.config.details_on_dblclick = true;
            gantt.config.highlight_critical_path = true;
            gantt.config.row_height = 26;
            gantt.config.show_chart = true;
            gantt.config.show_quick_info = true;
            gantt.config.show_progress = true;
            gantt.config.smart_scales = true;
            gantt.config.sort = true;


            // several scales at once
            gantt.config.scales = [
                {unit: "month", step: 1, format: "%F, %Y"},
                {unit: "day", step:1, format: "%d %D" }
            ];

            gantt.attachEvent("onBeforeTaskDrag", function(id, mode, e){
                var modes = gantt.config.drag_mode;
                switch (mode){
                    case modes.move:
                    break;
                    case modes.resize:
                    break;
                    case modes.progress:
                    break;
                }
            });
            gantt.attachEvent("onLinkDblClick", function(id,e){
                //any custom logic here
                return false;
            });
            gantt.attachEvent("onTaskDblClick", function(id,e){
                //any custom logic here
                return false;
            });

            gantt.templates.task_text=function(start,end,task){
                return "<b>"+task.type+":</b> "+task.text+",<b> Prioridade:</b> "+task.priority;
            };

            gantt.config.columns = [
                {name: "text", label: "-", tree: true, width: '*'},
                {name: "priority", label: "Prioridade", align:'center', width: '*'},
            ];

            gantt.init(this.$refs.gantt)
            // gantt.parse(this.$props.tasks)
            gantt.open("2");
            gantt.load(`/gantt/data-blobal?project_identifier=${this.project ? this.project : ''}`)
        }
    })
</script>
<style scoped>
    @import "~dhtmlx-gantt/codebase/dhtmlxgantt.css";
</style>
