class ResponseDataModel {
  constructor(
    {
      success = false,
      errors = [],
    } = {}
  ) {
    this.success = success;
    this.errors = errors;
  }
}

module.exports = ResponseDataModel;
