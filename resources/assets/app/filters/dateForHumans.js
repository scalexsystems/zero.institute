import moment from 'moment'

export default function (date) {
  const value = moment(date)
  return value.isValid() ? value.format('D MMMM YYYY') : ''
}
