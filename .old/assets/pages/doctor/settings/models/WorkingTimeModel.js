import WorkingDayModel from './WorkingDayModel';

class WorkingTimeModel {
  constructor(
    {
      monday = new WorkingDayModel(),
      tuesday = new WorkingDayModel(),
      wednesday = new WorkingDayModel(),
      thursday = new WorkingDayModel(),
      friday = new WorkingDayModel(),
      vacation = new WorkingDayModel(),
    } = {},
  ) {
    this.monday = monday;
    this.tuesday = tuesday;
    this.wednesday = wednesday;
    this.thursday = thursday;
    this.friday = friday;
    this.vacation = vacation;
  }
}

export default WorkingTimeModel;
