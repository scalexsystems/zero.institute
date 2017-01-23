import isString from 'lodash/isString';

export default {
  props: {
    name: String,
    title: String,
    subtitle: String,
    value: {
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    feedback: null,
    feedbackType: {
      default: 'danger',
      validator(value) {
        return ['danger', 'success', 'warning'].indexOf(value) > -1;
      },
    },
  },
  computed: {
    id() {
      const uid = this._uid;

      return `id${uid}`;
    },
    identifier() {
      const name = this.name;
      const raw = null;

      return name || raw;
    },
    feedbackState() {
      const feedback = this.feedbackType;
      const condition = this.feedback !== undefined;

      if (condition && isString(feedback)) {
        return `has-${feedback}`;
      }

      return '';
    },
    formControlState() {
      const feedback = this.feedbackType;
      const condition = this.feedback !== undefined;

      if (condition && isString(feedback)) {
        return `form-control-${feedback}`;
      }

      return '';
    },
  },
  methods: {
    is: isString,
  },
};
