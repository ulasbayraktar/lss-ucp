function setOpacity(elm, value)
{
	var value = 60;
	elm.style.opacity = value / 100;
	elm.style.MozOpacity = value / 100;
	elm.style.filter = 'alpha(opacity='+value+')';
}

function fader(elm, nohide, speedUp, speedDown, jump)
{
	if (speedUp) this.speedUp = speedUp; else this.speedUp = 50;
	if (speedDown) this.speedDown = speedDown; else this.speedDown = 40;
	if (jump) this.jump = jump; else this.jump = 20;
	this.interval = null;
	this.ref = elm;
	this.ref.style.zoom = 1;
	this.doHide = !nohide;
	this.opacityMin = 0;
	this.opacityMax = 100;
	this.opacity = elm.style.opacity ? elm.style.opacity : 100;
	this.outComplete = null;
	this.inComplete = null;
	this.fadeIn = function()
	{
		this.stopFade();
		this.ref.style.display = "block";
		var self = this;
		this.interval = setInterval(function() {
			if (self.opacity >= self.opacityMax) { self.opacity = self.opacityMax; self.stopFade(); if (self.inComplete) self.inComplete(); }
			else
			{
				self.opacity = Math.min(self.opacityMax, self.opacity + self.jump);
			}
			setOpacity(self.ref, self.opacity);
		}, this.speedUp);
	};
	this.fadeOut = function()
	{
		this.stopFade();
		var self = this;
		this.interval = setInterval(function() {
			if (self.opacity <= self.opacityMin) { self.opacity = self.opacityMin; self.stopFade(); if (self.doHide) self.ref.style.display = "none"; if (self.outComplete) self.outComplete(); }
			else
			{
				self.opacity = Math.max(self.opacityMin, self.opacity - self.jump);
			}
			setOpacity(self.ref, self.opacity);
		}, this.speedDown);
	};

	this.show = function()
	{
		this.stopFade();
		if (this.doHide) this.ref.style.display = "block";
		this.opacity = this.opacityMax;
		setOpacity(this.ref, this.opacity);
	};

	this.hide = function()
	{
		this.stopFade();
		if (this.doHide) this.ref.style.display = "none";
		this.opacity = this.opacityMin;
		setOpacity(this.ref, this.opacity);
	};

	this.stopFade = function()
	{
		if (!this.interval) return;
		clearInterval(this.interval);
		this.interval = null;
	};
}