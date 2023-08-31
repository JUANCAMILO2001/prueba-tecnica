<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Gráficas</h2>
            </div>
            <div class="card-body" >
               <div class="row">
                   <div class="col-12">
                       <h3>Gráfica de Ciudades con Usurios</h3>
                       <div className="chart-container" style="height: 50vh;">
                           <canvas ref="chartCanvas"></canvas>
                       </div>
                   </div>
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
                    params: { cityIds },
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
                const cityLabels = cityData.map(city => city.city_id);
                const userCounts = cityData.map(city => city.user_count);
                const cityNames = await this.fetchCityNames(cityLabels);
                const ctx = this.$refs.chartCanvas.getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: cityNames,
                        datasets: [
                            {
                                label: 'Usuarios por Ciudad',
                                data: userCounts,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.6)',
                                    'rgba(54, 162, 235, 0.6)',
                                    'rgba(54,235,96,0.6)',
                                    // Añade más colores de fondo si es necesario
                                ],
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
