import UserModel from '../../../../shared/models/UserModel';

class PatientModel extends UserModel {
  constructor(
    {
      pesel = '',
    } = {},
  ) {
    super();

    this.pesel = pesel;
  }
}

export default PatientModel;
