$(document).ready(function(){
	$.ajax({
		url: domain+"newchart/bargraph",
		method: "GET",
		success: function(data) {
			console.log(data);
			var day = [];
			var status = [];

			
			for(var i in data) {

				var tr = data[i].timestamp;

				var dateTime = new Date(tr*1000);
				var formatted = dateTime.toDateString();
				
				day.push("Date " + formatted);
				status.push(data[i].status);
			}


			var chartdata = {
				labels: day,
				datasets : [
					{
						label: 'Attendance status',
						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: status
					}
				]
			};

			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata,
				 options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero: true
			                }
			            }]
			        }
			    }
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});