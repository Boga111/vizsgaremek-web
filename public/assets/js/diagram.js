document.addEventListener("DOMContentLoaded", function () {
    const chartElem = document.getElementById("chart");
    if (chartElem) {
        if (window.chartLabels && window.chartData && window.chartLabels.length > 0) {

            new Chart(chartElem, {
                type: "bar",
                data: {
                    labels: window.chartLabels,
                    datasets: [
                        {
                            label: "Rendelt darabszám",
                            data: window.chartData
                        }
                    ]
                },
                options: {
                    responsive: true
                }
            });
        }
    }

    const revenueElem = document.getElementById("chartBevetel");
    if (revenueElem) {
        if (window.revLabels && window.revLabels.length > 0) {
            new Chart(revenueElem, {
                type: "line",
                data: {
                    labels: window.revLabels,
                    datasets: [
                        {
                            label: "Napi bevétel (nettó, ÁFA nélkül)",
                            data: window.revNetto,
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: "Napi bevétel (bruttó)",
                            data: window.revBrutto,
                            borderWidth: 2,
                            tension: 0.3,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return value + " Ft";
                                }
                            }
                        }
                    }
                }
            });
        }
    }
});