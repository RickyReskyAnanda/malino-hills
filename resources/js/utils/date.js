const isLeapYear = (year) => {
    return (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);
  };
  
export const getDaysInMonth = (year,bulan) => {
    const days =  [
      { days: 31 },
      { days: isLeapYear(year) ? 29 : 28 },
      { days: 31 },
      { days: 30 },
      { days: 31 },
      { days: 30 },
      { days: 31 },
      { days: 31 },
      { days: 30 },
      { days: 31 },
      { days: 30 },
      { days: 31 },
    ];
    return days[bulan-1];
  };

export const generateTableHeaders = (daysInMonth) => {
    return Array.from({ length: daysInMonth }, (_, index) => `${index + 1}`);
  };
  