import UserModel from '../../../../shared/models/UserModel';

class DoctorModel extends UserModel {
  constructor(
    {
      medicalSpecialty = 0,
      clinic = 0,
    } = {},
  ) {
    super();

    this.medicalSpecialty = medicalSpecialty;
    this.clinic = clinic;
  }
}

export default DoctorModel;
