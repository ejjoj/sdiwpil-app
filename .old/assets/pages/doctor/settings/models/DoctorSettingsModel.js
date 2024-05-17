import WorkingTimeModel from './WorkingTimeModel';
import UserSettingsModel from '../../../../shared/models/UserSettingsModel';

class DoctorSettingsModel extends UserSettingsModel {
  constructor(
    {
      medicalSpecialty = '',
      workingTime = new WorkingTimeModel(),
    } = {},
  ) {
    super();

    this.medicalSpecialty = medicalSpecialty;
    this.workingTime = workingTime;
  }
}

export default DoctorSettingsModel;
