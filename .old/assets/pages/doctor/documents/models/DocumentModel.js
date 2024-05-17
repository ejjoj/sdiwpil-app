class DocumentModel {
  constructor(
    {
      type = '',
      patient = 0,
      medicamentName = '',
      medicamentDescription = '',
      medicamentUsageDescription = '',
      medicamentRemission = '',
    } = {},
  ) {
    this.type = type;
    this.patient = patient;
    this.medicamentName = medicamentName;
    this.medicamentDescription = medicamentDescription;
    this.medicamentUsageDescription = medicamentUsageDescription;
    this.medicamentRemission = medicamentRemission;
  }
}

export default DocumentModel;
