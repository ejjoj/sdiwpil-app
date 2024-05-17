import { has } from 'lodash';

const vuelidateErrors = {
  methods: {
    getError(vField) {
      const errors = [];
      if (!vField || (vField && !vField.$dirty)) {
        return errors;
      }
      if (has(vField, 'required') && !vField.required) {
        errors.push('To pole jest wymagane');
      }
      if (has(vField, 'minLength') && !vField.minLength) {
        errors.push(`Minimalna ilość znaków to: ${vField.$params.minLength.min}`);
      }
      if (has(vField, 'maxLength') && !vField.maxLength) {
        errors.push(`Maksymalna ilość znaków to: ${vField.$params.maxLength.max}`);
      }
      if (has(vField, 'email') && !vField.email) {
        errors.push('Nieprawidłowy adres e-mail');
      }
      if (has(vField, 'sameAs') && !vField.sameAs) {
        errors.push('Wprowadzone hasła muszą być takie same');
      }

      return errors;
    },
  },
};

export default vuelidateErrors;
