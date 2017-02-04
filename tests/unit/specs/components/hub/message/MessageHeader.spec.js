import { createVM } from 'util'
import MessageHeader from 'app/components/hub/message/MessageHeader.vue'

/**
 * Header factory function
 * @param  template
 * @param  context  Test Context
 * @return VM
 */
function render (template, message, context) {
  return createVM(context, {
    template,
    components: { MessageHeader },
    data () {
      return { message }
    }
  })
}


describe('components/hub/message/MessageHeader.vue', function () {
  it('should render correctly', function () {
    const vm = render(`<message-header v-bind="{ message: message }"></message-header>`, {
      sender: {
        name: 'Rahul Kadyan'
      },
      received_at: '2017-01-27T17:26:45.810Z'
    }, this)
  })

  it('should render sending state', function () {
    const vm = render(`<message-header v-bind="{ message: message }"></message-header>`, {
      sender: {
        name: 'Rahul Kadyan'
      },
      $status: { sending: true },
      received_at: '2017-01-27T17:26:45.810Z'
    }, this)


    vm.$('i.fa.fa-circle-o-notch').should.exist
  })

  it('should render failed state', function () {
    const vm = render(`<message-header v-bind="{ message: message }"></message-header>`, {
      sender: {
        name: 'Rahul Kadyan'
      },
      $status: { failed: true, message: 'Network unavailable.' },
      received_at: '2017-01-27T17:26:45.810Z'
    }, this)

    vm.$el.should.have.class('failed')

    vm.$('i.fa.fa-warning').should.exist
  })
})
