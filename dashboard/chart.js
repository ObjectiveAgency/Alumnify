google.charts.load('current', {
	'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {

	var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		['Male', 11],
		
		['Demale', 2],
	
		
	]);

	var options = {
		title: 'My Daily Activities'
	};

	var chart = new google.visualization.PieChart(document.getElementById('piechart'));

	chart.draw(data, options);
}