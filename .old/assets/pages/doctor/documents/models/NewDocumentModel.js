import DocumentModel from './DocumentModel';

class NewDocumentModel extends DocumentModel {
  constructor(
    {
      doctor = 0,
    } = {},
  ) {
    super();

    this.doctor = doctor;
  }
}

export default NewDocumentModel;
