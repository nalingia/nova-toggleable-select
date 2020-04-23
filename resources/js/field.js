Nova.booting((Vue, router, store) => {
  Vue.component('index-toggleable-select', require('./components/IndexField'))
  Vue.component('detail-toggleable-select', require('./components/DetailField'))
  Vue.component('form-toggleable-select', require('./components/FormField'))
})
