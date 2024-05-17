import DocumentModel from './DocumentModel';

class EditDocumentModel extends DocumentModel {
  constructor(
    {
      document = 0,
    } = {},
  ) {
    super();

    this.document = document;
  }
}

export default EditDocumentModel;
