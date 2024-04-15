/*LIne-Chart */
// function linechart(package_no) {
function linechart(package_no, stage_id) {
    $(".tohide").hide();
    let chart_div = $("#tohide"+package_no);
    // $("#tohide"+package_no).show();
    $(chart_div).show();
    // $("fd"+package_no).show();
    var res;
    $.ajax({
        // url: baseUrl+"showgraph/"+package_no, 
        url: baseUrl+"showgraph/"+package_no+"/"+stage_id, 
        success: function(result) {
            // console.log(result);return false; 
            res = JSON.parse(result);
            /*console.log(res); 
            console.log("pp"+package_no);*/
              
            var labelRemove = res.labelArray.toString();  
            labelRemoveSplit = labelRemove.split(',');
            //console.log("labelRemove After   = "+labelRemoveSplit); 

            var packageTargetArray = res.packageTargetArray.toString();
            packageTargetSplit = packageTargetArray.split(',');

            var packageActualArray = res.packageActualArray.toString();
            packageActualSplit = packageActualArray.split(',');

            var financeActualArray = res.financeActualArray.toString();
            financeActualSplit = financeActualArray.split(',');

            var financeTargetArray = res.financeTargetArray.toString();
            financeTargetSplit = financeTargetArray.split(',');

            $(chart_div).find('#physical-graph-div .chart-container canvas').remove();
            let pp_canvas_id = 'pp'+package_no;
            $(chart_div).find('#physical-graph-div .chart-container').append('<canvas id="'+pp_canvas_id+'" class="h-275"></canvas>');
    
            // var ctx = document.getElementById("pp"+package_no).getContext('2d');
            var ctx = document.getElementById(pp_canvas_id).getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    //labels: ["Jan-23", "Feb-23", "Mar-23", "Apr-23", "May-23", "June-23", "July-23", "Aug-23", "Sep-23", "Oct-23", "Nov-23", "Dec-23", "Jan-24", "Feb-24", "Mar-24", "Apr-24", "May-24", "June-24", "July-24", "Aug-24", "Sep-24", "Oct-24", "Nov-24", "Dec-24"],
                    labels: labelRemoveSplit,
                    //labels: ["Sep-22","Oct-22","Nov-22","Dec-22","Jan-23","Feb-23","Mar-23","Apr-23","May-23","Jun-23","Jul-23","Aug-23","Sep-23","Oct-23","Nov-23","Dec-23","Jan-24","Feb-24","Mar-24","Apr-24","May-24","Jun-24"],
                    datasets: [
                        {
                            label: 'Acc Target',
                            //data: [100, 420, 210, 420, 210, 320, 350, 676, 878, 565, 343, 898, 100, 420, 210, 420, 210, 320, 350, 676, 878, 565, 343, 898],
                            // data : [res.packageTargetArray],
                            data : packageTargetSplit,
                            borderWidth: 2,
                            backgroundColor: 'transparent',
                            borderColor: '#6fad46',
                            borderWidth: 5,
                            lineTension:0.3,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 2
                        }, 
                        {
                            label: 'Acc Actual',
                            //data: [450, 200, 350, 250, 480, 200, 400, 897, 565, 454, 565, 342, 450, 200, 350, 250, 480, 200, 400, 897, 565, 454, 565, 342],
                            //data : [res.packageActualArray],
                            data : packageActualSplit,
                            borderWidth: 2,
                            backgroundColor: 'transparent',
                            borderColor: '#e97e35',
                            borderWidth: 5,
                            lineTension:0.3,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: "#9ba6b5",
                            },
                            display: true,
                            grid: {
                                color: 'rgba(119, 119, 142, 0.2)'
                            }
                        },
                        y: {
                            ticks: {
                                color: "#9ba6b5",
                            },
                            display: true,
                            grid: {
                                color: 'rgba(119, 119, 142, 0.2)'
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Thousands',
                                fontColor: 'rgba(119, 119, 142, 0.2)'
                            }
                        }
                    },
                    legend: {
                        labels: {
                            fontColor: "#9ba6b5"
                        },
                    },
                }
            });

            "use strict";
            /*LIne-Chart */
            $(chart_div).find('#financial-graph-div .chart-container canvas').remove();
            let fd_canvas_id = 'fd'+package_no;
            $(chart_div).find('#financial-graph-div .chart-container').append('<canvas id="'+fd_canvas_id+'" class="h-275"></canvas>');

            // var ctx = document.getElementById("fd"+package_no).getContext('2d');
            var ctx = document.getElementById(fd_canvas_id).getContext('2d');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    //labels: ["Jan-23","Feb-23","Mar-23","Apr-23","May-23","June-23","July-23","Aug-23","Sep-23","Oct-23","Nov-23","Dec-23"],
                    labels : labelRemoveSplit,
                    datasets: [
                        {
                            label: 'Acc Target',
                            //data: [100, 420, 210, 420, 210, 320, 350, 134, 453, 434, 545, 543],
                            data : financeTargetSplit,
                            borderWidth: 2,
                            backgroundColor: 'transparent',
                            borderColor: '#6fad46',
                            borderWidth: 5,
                            lineTension:0.3,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 2
                        }, 
                        {
                            label: 'Acc Actual',
                            //data: [450, 200, 350, 250, 480, 200, 400, 323, 434, 544, 233, 343],
                            data : financeActualSplit,
                            borderWidth: 2,
                            backgroundColor: 'transparent',
                            borderColor: '#e97e35',
                            borderWidth: 5,
                            lineTension:0.3,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            ticks: {
                                color: "#9ba6b5",
                            },
                            display: true,
                            grid: {
                                color: 'rgba(119, 119, 142, 0.2)'
                            }
                        },
                        y: {
                            ticks: {
                                color: "#9ba6b5",
                            },
                            display: true,
                            grid: {
                                color: 'rgba(119, 119, 142, 0.2)'
                            },
                            scaleLabel: {
                                display: false,
                                labelString: 'Thousands',
                                fontColor: 'rgba(119, 119, 142, 0.2)'
                            }
                        }
                    },
                    legend: {
                        labels: {
                            fontColor: "#9ba6b5"
                        },
                    },
                }
            });
        }
    });
}