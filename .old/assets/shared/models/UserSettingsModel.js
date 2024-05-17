class UserSettingsModel {
  constructor(
    {
      email = '',
      password = {
        first: '',
        second: '',
      },
    } = {},
  ) {
    this.email = email;
    this.password = password;
  }
}

export default UserSettingsModel;
