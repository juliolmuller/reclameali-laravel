
numeral.register('locale', 'pt-BR', {
  delimiters: {
    thousands: '.',
    decimal: ','
  },
  abbreviations: {
    thousand: 'k',
    million: 'M',
    billion: 'B',
    trillion: 'T'
  },
  currency: {
      symbol: 'R$'
  },
  ordinal() {
    return 'º'
  }
})
