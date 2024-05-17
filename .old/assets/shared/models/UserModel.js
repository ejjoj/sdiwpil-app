import PasswordModel from './PasswordModel';

class UserModel {
  constructor(
    {
      firstName = '',
      secondName = '',
      lastName = '',
      agreeTerms = false,
      email = '',
      password = new PasswordModel(),
    } = {},
  ) {
    this.firstName = firstName;
    this.secondName = secondName;
    this.lastName = lastName;
    this.agreeTerms = agreeTerms;
    this.email = email;
    this.password = password;
  }
}

export default UserModel;
