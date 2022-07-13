	ajaxCall = (dayDate) =>{
		let value = 0;
		const formData = new FormData();
		formData.append('dayDate',dayDate);
		let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                myObj = JSON.parse(this.response);
                value = myObj.return;
            }
        }
        xhttp.open("POST", "./include/INDEX-getSalesByDay.php", false);
        xhttp.send(formData);
        return value;
	}

	const today = new Date();
	let day = new Date();
	let datesSales = new Map();
	for(let i=0;i<=5;i++){
		day.setDate(today.getDate() - i);// console.log(day);
		let key = `${day.getFullYear()}-${day.getMonth() + 1}-${day.getDate()}`;// console.log(key);
		let sales = ajaxCall(key);//console.log(sales);
		datesSales.set(key,parseFloat(sales).toFixed(2));
	}
	let labelsForChart = []; 
	let valuesForChart = [];

	for (const [key, value] of datesSales) {
		labelsForChart.push(key);
		valuesForChart.push(value);
	}

	var ctx = document.getElementById('myChart');
		var myChart = new Chart(ctx, {
		    type: 'bar',
		    data: {
		        labels: labelsForChart,
		        datasets: [{
		            label: 'Orders',
		            data: valuesForChart,
		            backgroundColor: [
		                'rgba(255, 99, 132, 0.2)',
		                'rgba(54, 162, 235, 0.2)',
		                'rgba(255, 206, 86, 0.2)',
		                'rgba(75, 192, 192, 0.2)',
		                'rgba(153, 102, 255, 0.2)',
		                'rgba(255, 159, 64, 0.2)'
		            ],
		            borderColor: [
		                'rgba(255, 99, 132, 1)',
		                'rgba(54, 162, 235, 1)',
		                'rgba(255, 206, 86, 1)',
		                'rgba(75, 192, 192, 1)',
		                'rgba(153, 102, 255, 1)',
		                'rgba(255, 159, 64, 1)'
		            ],
		            borderWidth: 1
		        }]
		    },
		    options: {
		        scales: {
		            yAxes: [{
		                ticks: {
		                    beginAtZero: true,
		                    stepSize: 1000,
		                    callback: function(value, index, values) {
                        		return '$' + value;
                    		}
		                }
		            }]
		        },
		        tooltips: {
		            callbacks: {
		                label: function(tooltipItem, data) {
		                	let label = tooltipItem.yLabel;
		                    // var label = data.datasets[tooltipItem.datasetIndex];	
		                    return '$' + label;
		                }
		            }
		        }

		    }
		});

	// console.log(datesSales);

	