document.addEventListener("DOMContentLoaded", function () {
    const energySavingTipsSection = document.getElementById("gas-saving-tips");

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
            console.error("UL element not found inside 'gas-saving-tips' section.");
        }
    } else {
        console.error("Element with ID 'gas-saving-tips' not found.");
    }
    animateSectionOnScroll("production-methods");
    animateSectionOnScroll("distribution-network");
	
	const consumptionData1 = {
        labels: ["2019", "2020", "2021", "2022", "2023"],
        datasets: [{
            label: "Son 5 Yılın Doğalgaz Tüketimi",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            data: [109, 157, 117, 186, 212],
        }],
    };

    const consumptionData2 = {
        labels: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
        datasets: [{
            label: "2023 Doğalgaz Tüketimi",
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            data: [110, 175, 169, 283, 195, 188, 134, 152, 287, 295, 293, 321],
        }],
    };

    const barData1 = {
        labels: ["Doğal Kaynaklar", "Sondaj", "Arıtma"],
        datasets: [{
            label: "Çubuk Grafiği",
            backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)"],
            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)"],
            borderWidth: 1,
            data: [755, 510, 630],
        }],
    };

  const barData2 = {
        labels: ["Sanayi", "Mutfak Kullanımı", "Ev Isıtma", "Enerji Üretimi"],
        datasets: [{
            label: "Çubuk Grafiği",
            backgroundColor: ["rgba(255, 99, 132, 0.2)", "rgba(54, 162, 235, 0.2)", "rgba(255, 206, 86, 0.2)", "rgba(54, 82, 135, 0.2)"],
            borderColor: ["rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)", "rgba(54, 82, 135, 1)"],
            borderWidth: 1,
            data: [778, 552, 650, 865],
        }],
    };
	
    const doughnutData = {
        labels: ["Boru Hatları", "Depolama Tesisleri", "Dağıtım Hatları"],
        datasets: [{
            data: [462, 256, 593],
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

