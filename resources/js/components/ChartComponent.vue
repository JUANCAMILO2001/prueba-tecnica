<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Gráfica de Ciudades</h2>
            </div>
            <div class="card-body" >
                <div className="chart-container" style="height: 50vh;">
                    <canvas ref="chartCanvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Chart } from 'chart.js/auto';
import axios from 'axios';

export default {
    mounted() {
        this.fetchAndCreateChart();
    },
    methods: {
        async fetchCityNames(cityIds) {
            try {
                const response = await axios.get('/get-city-names', {
                    params: { cityIds }, // Envía los IDs de ciudad al servidor
                });
                return response.data;
            } catch (error) {
                console.error('Error fetching city names:', error);
                return [];
            }
        },
        async fetchAndCreateChart() {
            try {
                const response = await axios.get('/users-by-city');
                const cityData = response.data;

                // Obtén los datos para el gráfico
                const cityLabels = cityData.map(city => city.city_id);
                const userCounts = cityData.map(city => city.user_count);

                // Obtén los nombres de las ciudades correspondientes a los IDs
                const cityNames = await this.fetchCityNames(cityLabels);

                // Configura el contexto del lienzo
                const ctx = this.$refs.chartCanvas.getContext('2d');

                // Configura el gráfico utilizando Chart.js
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: cityNames, // Utiliza los nombres de las ciudades en lugar de los IDs
                        datasets: [
                            {
                                label: 'Usuarios por Ciudad',
                                data: userCounts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    },
                });
            } catch (error) {
                console.error('Error fetching city data:', error);
            }
        },
    },
};

</script>

<style scoped>
.chart-container {
    max-width: 600px;
    margin: 0 auto;
}
</style>
