export function formatNumber(number, locale = 'id-ID') {
    return number.toLocaleString(locale, {
      minimumFractionDigits: 0,
      maximumFractionDigits: 0
    });
  }