String.prototype.stripTags = function()
{
  return this.replace(/<\/?\w+[^>]*\/?>/g, '');
};