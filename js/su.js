document.addEventListener("DOMContentLoaded", function () {
    const energySavingTipsSection = document.getElementById("water-saving-tips");

    if (energySavingTipsSection) {
        const tipsList = energySavingTipsSection.querySelector("ul");

        if (tipsList) {
            tipsList.addEventListener("mouseover", function (event) {
                if (event.target.tagName === "LI") {
                    event.target.style.backgroundColor = "#ecf0f1";
                }
            });

            tipsList.addEventListener("mouseout", function (event) {
                if (event.target.tagName === "LI") {
                    event.target.style.backgroundColor = "transparent";
                }
            });
        } else {
            console.error("UL element not found inside 'water-saving-tips' section.");
        }
    } else {
        console.error("Element with ID 'water-saving-tips' not found.");
    }
    animateSectionOnScroll("production-methods");
    animateSectionOnScroll("distribution-network");
	
	const consumptionData1 = {
        labels: ["2019", "2020", "2021", "2022", "2023"],
        datasets: [{
            label: "Son 5 Yılın Su Tüketimi",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            data: [89, 57, 97, 86, 112],
        }],
    };

    const consumptionData2 = {
        labels: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
        datasets: [{
            label: "2023 Su Tüketimi",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            data: [90, 75, 79, 83, 95, 105, 134, 152, 83, 85, 93, 91],
        }],
    };

    const barData1 = {
        labels: ["Yağmur Suyu Toplama", "Göletler", "Su Arıtma Tesisleri"],
        datasets: [{
            label: "Çubuk Grafiği",
            backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)"],
            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)"],
            borderWidth: 1,
            data: [55, 10, 30],
        }],
    };

  const barData2 = {
        labels: ["Evsel Kullanım", "Tarım", "Endüstriyel Faaliyetler", "Enerji Üretimi"],
        datasets: [{
            label: "Çubuk Grafiği",
            backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(54, 82, 135, 0.2)"],
            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(54, 82, 135, 1)"],
            borderWidth: 1,
            data: [78, 52, 50, 65],
        }],
    };
	
    const doughnutData = {
        labels: ["Su Arıtma Tesisleri", "İletim Hatları", "Su Depoları"],
        datasets: [{
            data: [62, 56, 93],
            backgroundColor: ["rgba(255, 99, 132, 0.5)", "rgba(54, 162, 235, 0.5)", "rgba(255, 206, 86, 0.5)"],
        }],
    };
	
    createChart("consumptionChart1", "line", consumptionData1);
    createChart("consumptionChart2", "line", consumptionData2);
    createChart("barChart1", "bar", barData1);
    createChart("barChart2", "bar", barData2);
    createChart("doughnutChart", "doughnut", doughnutData);
});

function fadeIn(element, opacity) {
    let intervalId = setInterval(function () {
        if (opacity < 1) {
            opacity += 0.1;
            element.style.opacity = opacity;
        } else {
            clearInterval(intervalId);
        }
    }, 100);
}

function animateSectionOnScroll(sectionId) {
    const section = document.getElementById(sectionId);

    window.addEventListener("scroll", function () {
        const sectionPosition = section.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (sectionPosition < windowHeight * 0.8) {
            section.classList.add("animate");
        }
    });
}

function createChart(canvasId, type, data) {
    const ctx = document.getElementById(canvasId);

    if (ctx) {
        const chart = new Chart(ctx, {
            type: type,
            data: data,
        });

        return chart;
    } else {
        console.error(`Canvas element with id '${canvasId}' not found.`);
    }
}

