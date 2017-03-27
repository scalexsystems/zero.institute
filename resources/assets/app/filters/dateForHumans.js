import moment from 'moment'

export default function (date) {
  const value = moment(date, moment.ISO_8601, true)

  return value.isValid() ? value.format('D MMMM YYYY') : ''
}
