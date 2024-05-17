class AppointmentSearchModel {
  constructor(
    {
      medicalSpecialty = '',
      city = '',
      lastName = '',
    } = {},
  ) {
    this.medicalSpecialty = medicalSpecialty;
    this.city = city;
    this.lastName = lastName;
  }
}

export default AppointmentSearchModel;
