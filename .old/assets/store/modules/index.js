import { snakeCase } from 'lodash';

const requiredModules = require.context('.', false, /\.js$/);
const modules = {};

const addModules = (fileName, requiredModuleFunc) => {
  if (fileName === './index.js') {
    return;
  }

  const moduleConfig = requiredModuleFunc(fileName);
  const moduleName = snakeCase(fileName.replace(/(\.\/|\.js)/g, ''));
  modules[moduleName] = moduleConfig.default || moduleConfig;
};

requiredModules
  .keys()
  .forEach((fileName) => {
    addModules(fileName, requiredModules);
  });

export default modules;
