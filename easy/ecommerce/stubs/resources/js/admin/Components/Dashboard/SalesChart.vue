<template>
    <card separator>
        <template #header>
            <h3 class="text-sm">Sales Analytics</h3>
        </template>
        <LineChart :chartData="data" :options="options"/>
    </card>
</template>

<script setup>
import { ref } from 'vue';
import Card from "@/admin/Components/Ui/Card";
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

const props = defineProps({
    data: {
        type: Object,
        required: false,
        default: {
            title: '',
            number: 0,
            time_period: 'week',
            positive: true,
            percentage: 10
        }
    }
})

const data = {
    labels: ['label 1','label 2','label 3','label 4','label 5'],
    datasets: [{
        label: 'My First Dataset',
        data: [65, 59, 80, 81, 56, 55, 40],
        fill: false,
        borderColor: 'rgb(255,234,0)',
        tension: 0.4
    },
        {
            label: 'My Second Dataset',
            data: [40, 55, 56, 81, 59, 65, 40],
            fill: false,
            borderColor: 'rgb(0,44,255)',
            tension: 0.4
        }]
};

const options = ref({
    responsive: true,
});
</script>
