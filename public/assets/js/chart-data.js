var lineChartData = {
    labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Agu",
        "Sep",
        "Okt",
        "Nov",
        "Des"
    ],
    datasets: [
        {
            label: "Peminjaman Buku",
            fillColor: "rgba(48,164,255,0.2)",
            strokeColor: "rgba(48,164,255,1)",
            pointColor: "rgba(48,164,255,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(48,164,255,1)",
            data: dataPinjam
        }
    ]
};

var barChartData = {
    labels: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "Mei",
        "Jun",
        "Jul",
        "Agu",
        "Sep",
        "Okt",
        "Nov",
        "Des"
    ],
    datasets: [
        {
            fillColor: "rgba(48,164,255,0.5)",
            strokeColor: "rgba(48,164,255,0.8)",
            highlightFill: "rgba(48,164,255,0.75)",
            highlightStroke: "rgba(48,164,255,1)",
            data: dataPinjam
        }
    ]
};

var pieData = [
    {
        value: 100,
        color: "#30a5ff",
        highlight: "#62b9fb",
        label: "Peminjaman"
    },
    {
        value: 50,
        color: "#1ebfae",
        highlight: "#3cdfce",
        label: "Pengembalian"
    }
];

var doughnutData = [
    {
        value: 100,
        color: "#30a5ff",
        highlight: "#62b9fb",
        label: "Peminjaman"
    },
    {
        value: 50,
        color: "#1ebfae",
        highlight: "#3cdfce",
        label: "Pengembalian"
    }
];

window.onload = function () {

    var lineCanvas = document.getElementById("line-chart");
    if (lineCanvas) {
        var chart1 = lineCanvas.getContext("2d");
        window.myLine = new Chart(chart1).Line(
            lineChartData,
            {
                responsive: true
            }
        );
    }

    var barCanvas = document.getElementById("bar-chart");
    if (barCanvas) {
        var chart2 = barCanvas.getContext("2d");
        window.myBar = new Chart(chart2).Bar(
            barChartData,
            {
                responsive: true
            }
        );
    }

    var doughnutCanvas = document.getElementById("doughnut-chart");
    if (doughnutCanvas) {
        var chart3 = doughnutCanvas.getContext("2d");
        window.myDoughnut = new Chart(chart3).Doughnut(
            doughnutData,
            {
                responsive: true
            }
        );
    }

    var pieCanvas = document.getElementById("pie-chart");
    if (pieCanvas) {
        var chart4 = pieCanvas.getContext("2d");
        window.myPie = new Chart(chart4).Pie(
            pieData,
            {
                responsive: true
            }
        );
    }

};