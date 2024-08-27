import React from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';

const SplineChart = ({ title, data, category }) => {
  const options = {
    title: {
      text: title || 'Line Chart'
    },
    xAxis: {
      categories: category // 3 objects
    },
    yAxis: {
      title: {
        text: 'Values'
      }
    },
    series: data || []
  };

  return (
    <HighchartsReact highcharts={Highcharts} options={options} />
  );
};

export default SplineChart;
