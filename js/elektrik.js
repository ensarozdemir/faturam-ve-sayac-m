document.addEventListener("DOMContentLoaded", function () {
    const energySavingTipsSection = document.getElementById("energy-saving-tips");

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
            console.error("UL element not found inside 'energy-saving-tips' section.");
        }
    } else {
        console.error("Element with ID 'energy-saving-tips' not found.");
    }
    animateSectionOnScroll("production-methods");
    animateSectionOnScroll("distribution-network");
	
	const consumptionData1 = {
        labels: ["2019", "2020", "2021", "2022", "2023"],
        datasets: [{
            label: "Son 5 Yılın Elektrik Tüketimi",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            data: [80, 67, 77, 66, 62],
        }],
    };

    const consumptionData2 = {
        labels: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
        datasets: [{
            label: "2023 Elektrik Tüketimi",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            data: [50, 60, 45, 70, 55, 80, 75, 90, 80, 65, 83, 97],
        }],
    };

    const barData = {
        labels: ["Fosil Yakıtlar", "Nükleer Enerji", "Rüzgar Enerjisi", "Güneş Enerjisi"],
        datasets: [{
            label: "Çubuk Grafiği",
            backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(54, 82, 135, 0.2)"],
            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(54, 82, 135, 1)"],
            borderWidth: 1,
            data: [55, 10, 30, 35],
        }],
    };

  
    const doughnutData = {
        labels: ["Trafo İstasyonları", "İletim Hatları", "Dağıtım Hatları"],
        datasets: [{
            data: [32, 56, 43],
            backgroundColor: ["rgba(255, 99, 132, 0.5)", "rgba(54, 162, 235, 0.5)", "rgba(255, 206, 86, 0.5)"],
        }],
    };
	
    createChart("consumptionChart1", "line", consumptionData1);
    createChart("consumptionChart2", "line", consumptionData2);
    createChart("barChart", "bar", barData);
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

