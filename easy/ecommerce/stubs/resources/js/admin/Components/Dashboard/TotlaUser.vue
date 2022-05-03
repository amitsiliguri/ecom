<template>
    <card separator>
        <template #header>
            <h3 class="text-sm">Total Users</h3>
        </template>
        <div class="flex justify-between items-center p-2">
            <h2 class="text-3xl font-extrabold">7,345</h2>
            <div class="w-24">
                <BarChart :chartData="data" :options="options"/>
            </div>
        </div>
        <template #footer>
            <h3 class="text-sm">5% last Week</h3>
        </template>
    </card>
</template>

<script setup>
import { ref } from 'vue';
import Card from "@/admin/Components/Ui/Card";
import { BarChart } from 'vue-chart-3';
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
        label: 'customers',
        data: [65, 59, 22, 33,44],
        backgroundColor: [
            'rgba(255, 99, 13)',
            'rgba(255, 159, 64)',
            'rgb(64,89,255)',
            'rgb(156,64,255)',
            'rgb(9,181,243)',
        ],
        borderColor: [
            'rgba(255, 99, 13)',
            'rgba(255, 159, 64)',
            'rgb(64,89,255)',
            'rgb(156,64,255)',
            'rgb(9,181,243)',
        ],
        borderWidth: 2,
    }]
};

const options = ref({
    responsive: true,
    tooltips: { display: false },
    plugins: {
        legend: {
            display: false
        },
        title: {
            display: false
        },
    },
    scales: {
        x: {
            display: false,
        },
        y: {
            display: false,
        }
    },
});
</script>
