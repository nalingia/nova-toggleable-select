<template>
  <default-field :field="field" :errors="errors">
    <template slot="field">
      <select-control
        :id="field.attribute"
        :dusk="field.attribute"
        v-model="value"
        class="w-full form-control form-select"
        :class="errorClasses"
        :options="field.options"
        :disabled="isReadonly"
      >
        <option value="" selected :disabled="!field.nullable">{{
          placeholder
        }}</option>
      </select-control>
    </template>
  </default-field>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';
import { flatten, uniq } from 'ramda';

export default {
  mixins: [HandlesValidationErrors, FormField],
  mounted() {
      if (this.hasFieldsToToggle) {
          this.toggleVisibility();
      }
  },
  methods: {
    /**
     * Provide a function that fills a passed FormData object with the
     * field's internal value attribute. Here we are forcing there to be a
     * value sent to the server instead of the default behavior of
     * `this.value || ''` to avoid loose-comparison issues if the keys
     * are truthy or falsey
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value)
    },
    cacheFields() {
        const components = this.$parent.$parent.$parent.$children
                .filter(c => c.panel)
                .flatMap(p => p.$children[1].$children)
                .filter(c => c.field);
        const mappings = {};

        components.forEach((c) => {
            mappings[c.field.attribute] = c;
        });

        this.fieldsMap = mappings;
    },
    toggleVisibility() {
        if (!this.fieldsMap) {
            this.cacheFields();
        }

        this.resetVisibility();

        const fields = this.field.toggle[this.value] || [];
        uniq(flatten(Object.values(this.field.toggle)))
          .filter(field => fields.indexOf(field) < 0)
          .forEach(field => {
            if (this.fieldsMap[field] && this.fieldsMap[field].handleChange) {
              this.fieldsMap[field].handleChange('');
            }
          });

        fields
            .forEach(field => {
                if (this.fieldsMap[field]) {
                    this.fieldsMap[field].$el.classList.remove('nalingia-toggleable-select-hidden');
                }
            });
    },
    resetVisibility() {
        Object.keys(this.field.toggle)
            .flatMap(value => this.field.toggle[value] || [])
            .forEach(field => {
                if (this.fieldsMap[field]) {
                    this.fieldsMap[field].$el.classList.add('nalingia-toggleable-select-hidden');
                }
            });
    },
  },

  data() {
      return {
          value: this.field.value || '',
          fieldsMap: null,
      };
  },

  computed: {
    /**
     * Return the placeholder text for the field.
     */
    placeholder() {
      return this.field.placeholder || this.__('Choose an option')
    },
    hasFieldsToToggle() {
        return this.field.toggle && Object.keys(this.field.toggle).length > 0;
    },
  },
  watch: {
      value: function () {
            if (this.hasFieldsToToggle) {
                this.toggleVisibility();
            }
      },
  }
}
</script>
