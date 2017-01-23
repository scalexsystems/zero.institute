import $ from 'jquery';

export default {
  bind(el, binding) {
    $(el).tooltip({
      placement: binding.arg,
    });
    el.setAttribute('data-original-title', binding.value || '');
  },
  update(el, binding) {
    if (el.getAttribute('data-original-title') !== binding.value) {
      el.setAttribute('data-original-title', binding.value || '');
    }
  },
  unbind(el) {
    if (!el) return;

    $(el).tooltip('hide');
    $(el).tooltip('dispose');
  },
};
