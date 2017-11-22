module.exports = class StringHelper {

	constructor() {}

	static truncString(string, len = 0) {

		if((len <= 0) || typeof string !== 'string') {
		  return '';
		}

		if(string.length <= len) {
		  return string;
		}

		return string.substr(0,len)+'...';
	}

}