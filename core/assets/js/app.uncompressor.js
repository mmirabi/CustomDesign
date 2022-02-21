 /*
 *
 * Customdesign Designer Tool ver1.7
 *
 * https://www.rugcustom.com
 * Copyright 2018-2019 : Customdesign product designer tool
 * All rights reserved by Customdesign Inc
 *
 * This source code is licensed under non-distrbutable rights of Customdesign
 * https://www.rugcustom.com/terms-conditions/
 *
 */

 jQuery(document).ready(function($) {
	
	// Use strict for the private workspace

	window.customdesign = {

		e : {
			tools : $('#customdesign-top-tools'),
			layers : $('#customdesign-layers'),
			main : $('#CustomdesignDesign')
		},
		
		i : function(s){
			return customdesign.data.js_lang[s.toString()];
		},
		
		f : function(msg) {
			
			if (msg === undefined || msg === '' || msg === false) {
				clearTimeout(customdesign.ops.ftimer);
				document.getElementById('CustomdesignDesign').setAttribute('data-processing', '');
				document.getElementById('CustomdesignDesign').setAttribute('data-msg', '');
			} else {
				clearTimeout(customdesign.ops.ftimer);
				customdesign.ops.ftimer = setTimeout(function(msg) {
					document.getElementById('CustomdesignDesign').setAttribute('data-processing', 'true');
					document.getElementById('CustomdesignDesign').setAttribute('data-msg', msg);
				}, 300, msg);
			}
			
		},
		
		data : {},
		
		filters : [],

		ops : {
			downon: null,
			drag_start: null,
			first: {},
			categories: {},
			before_unload: null,
			excmobile: false,
			first_completed: false,
			session_designs: [], // save currelly designs of all stages
			my_designs: {}, // Save currently my designs list
			export_list: [
				'id',
				'src',
				'origin_src',
				'evented',
				'visible',
				'selectable',
				'text',
				'fontFamily',
				'fontSize',
				'fontStyle',
				'textDecoration',
				'fontWeight',
				'font',
				'angle',
				'bridge',
				'name',
				'charSpacing',
				'lineHeight',
				'fill',
				'price',
				'resource',
				'resource_id',
				'fx',
				'opacity',
				'fxOrigin',
				'colors',
				'originX',
				'originY',
				'lockPosition',
				'group_pos',
				'imagebox',
				'boxbtn',
				'template',
				'full_src'
			],
			color_maps : {"#000000":"black","#000080":"navy","#00008b":"darkblue","#0000cd":"mediumblue","#0000ff":"blue","#006400":"darkgreen","#008000":"green","#008080":"teal","#008b8b":"darkcyan","#00bfff":"deepskyblue","#00ced1":"darkturquoise","#00fa9a":"mediumspringgreen","#00ff00":"lime","#00ff7f":"springgreen","#00ffff":"cyan","#191970":"midnightblue","#1e90ff":"dodgerblue","#20b2aa":"lightseagreen","#228b22":"forestgreen","#2e8b57":"seagreen","#2f4f4f":"darkslategrey","#32cd32":"limegreen","#3cb371":"mediumseagreen","#40e0d0":"turquoise","#4169e1":"royalblue","#4682b4":"steelblue","#483d8b":"darkslateblue","#48d1cc":"mediumturquoise","#4b0082":"indigo","#556b2f":"darkolivegreen","#5f9ea0":"cadetblue","#6495ed":"cornflowerblue","#663399":"rebeccapurple","#66cdaa":"mediumaquamarine","#696969":"dimgrey","#6a5acd":"slateblue","#6b8e23":"olivedrab","#708090":"slategrey","#778899":"lightslategrey","#7b68ee":"mediumslateblue","#7cfc00":"lawngreen","#7fff00":"chartreuse","#7fffd4":"aquamarine","#800000":"maroon","#800080":"purple","#808000":"olive","#808080":"grey","#87ceeb":"skyblue","#87cefa":"lightskyblue","#8a2be2":"blueviolet","#8b0000":"darkred","#8b008b":"darkmagenta","#8b4513":"saddlebrown","#8fbc8f":"darkseagreen","#90ee90":"lightgreen","#9370db":"mediumpurple","#9400d3":"darkviolet","#98fb98":"palegreen","#9932cc":"darkorchid","#9acd32":"yellowgreen","#a0522d":"sienna","#a52a2a":"brown","#a9a9a9":"darkgrey","#add8e6":"lightblue","#adff2f":"greenyellow","#afeeee":"paleturquoise","#b0c4de":"lightsteelblue","#b0e0e6":"powderblue","#b22222":"firebrick","#b8860b":"darkgoldenrod","#ba55d3":"mediumorchid","#bc8f8f":"rosybrown","#bdb76b":"darkkhaki","#c0c0c0":"silver","#c71585":"mediumvioletred","#cd5c5c":"indianred","#cd853f":"peru","#d2691e":"chocolate","#d2b48c":"tan","#d3d3d3":"lightgrey","#d8bfd8":"thistle","#da70d6":"orchid","#daa520":"goldenrod","#db7093":"palevioletred","#dc143c":"crimson","#dcdcdc":"gainsboro","#dda0dd":"plum","#deb887":"burlywood","#e0ffff":"lightcyan","#e6e6fa":"lavender","#e9967a":"darksalmon","#ee82ee":"violet","#eee8aa":"palegoldenrod","#f08080":"lightcoral","#f0e68c":"khaki","#f0f8ff":"aliceblue","#f0fff0":"honeydew","#f0ffff":"azure","#f4a460":"sandybrown","#f5deb3":"wheat","#f5f5dc":"beige","#f5f5f5":"whitesmoke","#f5fffa":"mintcream","#f8f8ff":"ghostwhite","#fa8072":"salmon","#faebd7":"antiquewhite","#faf0e6":"linen","#fafad2":"lightgoldenrodyellow","#fdf5e6":"oldlace","#ff0000":"red","#ff00ff":"magenta","#ff1493":"deeppink","#ff4500":"orangered","#ff6347":"tomato","#ff69b4":"hotpink","#ff7f50":"coral","#ff8c00":"darkorange","#ffa07a":"lightsalmon","#ffa500":"orange","#ffb6c1":"lightpink","#ffc0cb":"pink","#ffd700":"gold","#ffdab9":"peachpuff","#ffdead":"navajowhite","#ffe4b5":"moccasin","#ffe4c4":"bisque","#ffe4e1":"mistyrose","#ffebcd":"blanchedalmond","#ffefd5":"papayawhip","#fff0f5":"lavenderblush","#fff5ee":"seashell","#fff8dc":"cornsilk","#fffacd":"lemonchiffon","#fffaf0":"floralwhite","#fffafa":"snow","#ffff00":"yellow","#ffffe0":"lightyellow","#fffff0":"ivory","#ffffff":"white"}
		},

		trigger : function( obj ) {

			var func;
			for( var ev in obj.events ){

				if( typeof obj.events[ev] == 'function' )
					func = obj.events[ev];
				else if( typeof obj[obj.events[ev]] == 'function' )
					func = obj[obj.events[ev]];
				else continue;

				ev = ev.split(',');

				ev.map(function(evs){

					evs = evs.split(':');

					if(evs[1] === undefined)evs[1] = 'click';

					if (evs[0] === '')
						obj.el.off(evs[1]).on( evs[1], obj, func );
					else obj.el.find( evs[0] ).off(evs[1]).on( evs[1], obj, func );

				});

			}
		},
		
		add_filter : function(name, callback, priority) {
			
			if (priority === undefined)
				priority = 10;
				
			if (this.filters[priority] === undefined)
				this.filters[priority] = {};
				
			if (this.filters[priority][name] === undefined)
				this.filters[priority][name] = [];
				
			if (typeof callback == 'function')
				this.filters[priority][name].push(callback);
				
		},

		apply_filter : function(name, obj, p) {
			
			return this.apply_filters(name, obj, p);

		},
		
		apply_filters : function(name, obj, p) {
			
			this.filters.map(function(filters) {
				if (filters[name] !== undefined) {
					filters[name].map(function(filter){
						if (typeof filter == 'function')
							obj = filter(obj, p);
					});
				}
			});

			return obj;

		},
		
		add_action : function(name, callback, priority) {
			
			this.actions.add(name, callback, priority);
			
		},

		do_action : function(name, obj, p) {

			return this.actions.do(name, obj, p);
		},

		itemInStage: function(action){
			let product_base = customdesign.fn.url_var('product_base', '');
			let product_cms = customdesign.fn.url_var('product_cms', '');
			let stageName = customdesign.stage().name;

			let session_name = product_base+'_'+product_cms+'_'+stageName+'_canvasBase';
			let countObj = customdesign.stage().canvas.getObjects().length-1;

			// console.log(JSON.stringify(customdesign.cart.price));

			var getPriceStage = parseFloat($('div#customdesign-stage-nav li[data-stage="'+stageName+'"]').attr('data-additional_price'));
			if(isNaN(getPriceStage) || getPriceStage == undefined || getPriceStage == 'undefined' || getPriceStage.toString().trim() == ''){
				getPriceStage = 0;
			}
			
			if(action == 'add'){
				if(sessionStorage.getItem(session_name) === null){
					sessionStorage.setItem(session_name, customdesign.stage().canvas.getObjects().length-1);
				}
				if(getPriceStage != 0 && getPriceStage > 0 && sessionStorage.getItem(session_name) == countObj ){
					customdesign.cart.price.base = customdesign.cart.price.base+getPriceStage;
				}
			}

			if(action == 'del' && sessionStorage.getItem(session_name) !== null && sessionStorage.getItem(session_name) == countObj-1){
				sessionStorage.removeItem(session_name);
				if(getPriceStage != 0 && getPriceStage > 0){
					customdesign.cart.price.base = customdesign.cart.price.base-getPriceStage;
				}
			}
		},
		
		extends : {

			controls : {

				calcCoords: function(absolute) {

			      var theta = this.angle * (Math.PI / 180),
			          vpt = this.getViewportTransform(),
			          dim = absolute ? this._getTransformedDimensions() : this._calculateCurrentDimensions(),
			          currentWidth = dim.x, currentHeight = dim.y,
			          sinTh = Math.sin(theta),
			          cosTh = Math.cos(theta),
			          _angle = currentWidth > 0 ? Math.atan(currentHeight / currentWidth) : 0,
			          _hypotenuse = (currentWidth / Math.cos(_angle)) / 2,
			          offsetX = Math.cos(_angle + theta) * _hypotenuse,
			          offsetY = Math.sin(_angle + theta) * _hypotenuse,
			          center = this.getCenterPoint(),
			          // offset added for rotate and scale actions
			          coords = absolute ? center : fabric.util.transformPoint(center, vpt),
			          tl  = new fabric.Point(coords.x - offsetX, coords.y - offsetY),
			          tr  = new fabric.Point(tl.x + (currentWidth * cosTh), tl.y + (currentWidth * sinTh)),
			          bl  = new fabric.Point(tl.x - (currentHeight * sinTh), tl.y + (currentHeight * cosTh)),
			          br  = new fabric.Point(coords.x + offsetX, coords.y + offsetY);

			      if (!absolute) {
			        var ml  = new fabric.Point((tl.x + bl.x) / 2, (tl.y + bl.y) / 2),
			            mt  = new fabric.Point((tr.x + tl.x) / 2, (tr.y + tl.y) / 2),
			            mr  = new fabric.Point((br.x + tr.x) / 2, (br.y + tr.y) / 2),
			            mb  = new fabric.Point((br.x + bl.x) / 2, (br.y + bl.y) / 2),
			            mtr = new fabric.Point(tl.x + (currentWidth * cosTh), tl.y + (currentWidth * sinTh));
			            //mtr = new fabric.Point(mt.x + sinTh * this.rotatingPointOffset, mt.y - cosTh * this.rotatingPointOffset);
			      }

			      var coords = {
			        // corners
			        tl: tl, tr: tr, br: br, bl: bl,
			      };

			      if (!absolute) {
			        // middle
			        coords.ml = ml;
			        coords.mt = mt;
			        coords.mr = mr;
			        coords.mb = mb;
			        // rotating point
			        coords.mtr = mtr;
			      }

			      return coords;

			    },

				drawControls: function(ctx) {
					
					if (!this.hasControls) {
						return this;
					}

					var wh = this._calculateCurrentDimensions(),
						width = wh.x,
						height = wh.y,
						scaleOffset = this.cornerSize,
						left = -(width + scaleOffset) / 2,
						top = -(height + scaleOffset) / 2,
						methodName = this.transparentCorners ? 'stroke' : 'fill',
						active = customdesign.stage().canvas.getActiveObject();

					ctx.save();
						
					if (this.hasRotatingPoint) {
						
						if (active !== null && active.get('lockPosition') === true) {
							ctx.fillStyle = '#f75555';
							ctx.fillRect(left, top,this.cornerSize,this.cornerSize);
							ctx.drawImage(
								customdesign.objects.icons['del'], 
								left+this.cornerSize*0.1, 
								top+this.cornerSize*0.1, 
								this.cornerSize*0.8, this.cornerSize*0.8
							);
						} else {
						
					        var canvas = customdesign.stage().canvas,
					        	isobj = canvas.getActiveObject(),
					       		isgroup = canvas.getActiveGroup(),
					        	invert = customdesign.get.color('invert');
							
					        
							ctx.fillStyle = invert == '#333' ? '#777' : '#ccc';
					        
							var pos = {
								'rot': [left+width+this.cornerSize*0.1, top+this.cornerSize*0.1], 
								'rez': [left+width+this.cornerSize*0.1, top+height+this.cornerSize*0.1], 
								'del': [left+this.cornerSize*0.1, top+this.cornerSize*0.1]
							}, c = this.cornerSize*0.8;
							
							if (
								isobj && 
								(
									isobj.imagebox === undefined || 
									isobj.imagebox === '' || 
									canvas.getObjects().filter(function(o) {
										return o.id == isobj.imagebox;
									}).length === 0
								)
							) {
								pos.dou = [left+this.cornerSize*0.1, top+height+this.cornerSize*0.1];
								ctx.fillRect(left, top+height,this.cornerSize,this.cornerSize);
							};	 
							
							// Top Right
							ctx.fillRect(left+width, top,this.cornerSize,this.cornerSize);
							//Bottom Right
							ctx.fillRect(left+width, top+height,this.cornerSize,this.cornerSize);
							
							// Center Top
							ctx.beginPath();
						    ctx.arc(left+(width/2)+(this.cornerSize/2), top+(this.cornerSize/2), 3, 0, 2 * Math.PI, false);
						    ctx.fill();
						    ctx.closePath();
						    
						    // Center Bottom
						    ctx.beginPath();
						    ctx.arc(left+(width/2)+(this.cornerSize/2), top+height+(this.cornerSize/2), 3, 0, 2 * Math.PI, false);
						    ctx.fill();
							ctx.closePath();
							
							// Right Midle
						    ctx.beginPath();
						    ctx.arc(left+(this.cornerSize/2)-.5, top+(height/2)+(this.cornerSize/2), 3, 0, 2 * Math.PI, false);
						    ctx.fill();
						    ctx.closePath();
						    
						    // Left Midle
						    ctx.beginPath();
						    ctx.arc(left+width+(this.cornerSize/2)+.5, top+(height/2)+(this.cornerSize/2), 3, 0, 2 * Math.PI, false);
						    ctx.fill();
							ctx.closePath();
							
							// Top Left
							ctx.fillStyle = '#f75555';
							ctx.fillRect(left, top,this.cornerSize,this.cornerSize);
							
							
							Object.keys(pos).map(function(p){
								ctx.drawImage(
									customdesign.objects.icons[(invert == '#333' || p == 'del' ? '' : 'w')+p], 
									pos[p][0], 
									pos[p][1], 
									c, c
								);
							});
						}

					}

					ctx.restore();

					return this;

				},

				drawBorders: function(ctx) {

					if (!this.hasBorders) {
						return this;
					}

					var wh = this._calculateCurrentDimensions(),
						strokeWidth = 1 / this.borderScaleFactor,
						width = wh.x + strokeWidth,
						height = wh.y + strokeWidth;

					ctx.save();
					ctx.strokeStyle = customdesign.get.color('invert') == '#333' ? 'rgba(30, 30, 30, 0.35)' : 'rgba(230, 230, 230, 0.6)';

					this._setLineDash(ctx, [1, 1], null);

					ctx.strokeRect(
						-width / 2,
						-height / 2,
						width,
						height
					);

					if (
						this.hasRotatingPoint &&
						this.isControlVisible('mtr') &&
						!this.get('lockRotation') &&
						this.hasControls
					) {

						var rotateHeight = -height / 2;

						ctx.beginPath();
						ctx.moveTo(0, rotateHeight);
						ctx.lineTo(0, rotateHeight - this.rotatingPointOffset);
						ctx.closePath();
						ctx.stroke();
					}

					ctx.restore();

					return this;

				},

				targetCorner: function(pointer) {

					if (!this.hasControls || !this.active) {
				        return false;
				      }

				      var ex = pointer.x,
				          ey = pointer.y,
				          xPoints,
				          lines;
				      this.__corner = 0;
				      for (var i in this.oCoords) {

				        if (!this.isControlVisible(i)) {
				          continue;
				        }

				        if (i === 'mtr' && !this.hasRotatingPoint) {
				          continue;
				        }

				        if (this.get('lockUniScaling') &&
				           (i === 'mt' || i === 'mr' /*|| i === 'mb'*/ || i === 'ml')) {
				          continue;
				        }

				        lines = this._getImageLines(this.oCoords[i].corner);

						//FPD: target corner not working when canvas has zoom greater than 1
				        var zoom = this.canvas.getZoom() ? this.canvas.getZoom() : 1;

				        xPoints = this._findCrossPoints({ x: ex*zoom, y: ey*zoom }, lines);
				        if (xPoints !== 0 && xPoints % 2 === 1) {
				          this.__corner = i;
				          return i;
				        }
				      }
				      return false;
				},

			},

			canvas : {

				_getRotatedCornerCursor: function(corner, target, e) {

					var cu = 'move';

					switch (corner) {
						case 'tr': cu = 'crosshair'; break;
						case 'tl': cu = 'pointer'; break;
						case 'br': cu = 'nwse-resize'; break;
						case 'bl': cu = 'pointer'; break;
						case 'mt': cu = 'n-resize'; break;
						case 'mr': cu = 'e-resize'; break;
						case 'mb': cu = 's-resize'; break;
						case 'ml': cu = 'w-resize'; break;
					}

					return cu;

			      var n = Math.round((target.getAngle() % 360) / 45);

			      if (n < 0) {
			        n += 8; // full circle ahead
			      }
			      n += cursorOffset[corner];
			      if (e[this.altActionKey] && cursorOffset[corner] % 2 === 0) {
			        //if we are holding shift and we are on a mx corner...
			        n += 2;
			      }
			      // normalize n to be from 0 to 7
			      n %= 8;

				  if (corner == 'tl')
				  	return 'pointer';

			      return this.cursorMap[n];

			    },

			    _setupCurrentTransform: function (e, target) {

					if (!target) {
						return;
					}

					var pointer = this.getPointer(e),
						corner = target._findTargetCorner(this.getPointer(e, true)),
						action = this._getActionFromCorner(target, corner, e),
						origin = this._getOriginFromCorner(target, corner);

					if (customdesign.fn.ctrl_btns({e: e, target: target}) === true)
						return;

					if (action == 'drag') {
						customdesign.ops.downon = target;
						customdesign.ops.moved = false;
					}

					this._currentTransform = {
						target: target,
						action: action,
						corner: corner,
						scaleX: target.scaleX,
						scaleY: target.scaleY,
						skewX: target.skewX,
						skewY: target.skewY,
						offsetX: pointer.x - target.left,
						offsetY: pointer.y - target.top,
						originX: origin.x,
						originY: origin.y,
						ex: pointer.x,
						ey: pointer.y,
						lastX: pointer.x,
						lastY: pointer.y,
						left: target.left,
						top: target.top,
						theta: fabric.util.degreesToRadians(target.angle),
						width: target.width * target.scaleX,
						mouseXSign: 1,
						mouseYSign: 1,
						shiftKey: e.shiftKey,
						altKey: e[this.centeredKey]
					};

					this._currentTransform.original = {
						left: target.left,
						top: target.top,
						scaleX: target.scaleX,
						scaleY: target.scaleY,
						skewX: target.skewX,
						skewY: target.skewY,
						originX: origin.x,
						originY: origin.y
					};

					this._resetCurrentTransform();

				},

			}

		},

		objects : {

			events : {

				'selection:cleared' : function(opts) {
					customdesign.e.layers.find('li.active').removeClass('active');
					customdesign.actions.do('selection:cleared', opts);
					customdesign.stack.save();
				},
				
				'object:selected' : function(opts) {
					
					customdesign.stage().selected_object = opts.target;
					opts.target.setControlVisible('tr', false);
						
					if (opts.target.get('lockPosition') === true) {
						opts.target.lockMovementX = true;
						opts.target.lockMovementY = true;
						opts.target.setControlsVisibility({
							mt: false, 
							mb: false, 
							ml: false, 
							mr: false, 
							bl: false,
							br: false, 
							tl: true, 
							tr: false,
							mtr: false
						});
					} else {
						opts.target.lockMovementX = false;
						opts.target.lockMovementY = false;
						opts.target.setControlsVisibility({
							mt: true, 
							mb: true, 
							ml: true, 
							mr: true, 
							bl: true,
							br: true, 
							tl: true, 
							tr: false,
							mtr: true
						});
					};
					
					customdesign.actions.do('object:selected', opts);
					
				},

				'object:added' : function(opts) {
					customdesign.actions.do('object:added', opts);
				},
				
				'object:modified' : function(opts) {
					customdesign.actions.do('object:modified', opts);
				},

				'object:rotating': function(opts){

					[0, 45, 90, 135, 180, 225, 270, 315, 360].map(function(a){
						if (Math.abs(opts.target.angle-a) < 5)
							opts.target.angle = a;
					});

					customdesign.get.el('rotate').val(opts.target.angle).attr({'data-value': Math.round(opts.target.angle)+'º'});
				},
				
				'mouse:down': function(opts) {
					
					var stage = customdesign.stage(),
						objs = stage.canvas.getObjects();
					
					customdesign.ops.limit_snap = stage.limit_zone;
					
					if (stage.canvas.isDrawingMode && opts.e.shiftKey === false)
						return;
					
					customdesign.fn.navigation('clear');
					customdesign.ops.mousedown = true;

					if (opts.e && opts.e.shiftKey)
						stage.canvas.set('selection', false);
					
					if (
						opts.target === null || 
						(
							opts.target.__corner === 0 && 
							opts.target.imagebox !== undefined && 
							opts.target.imagebox !== ''
						)
					) {
						objs.map(function(o){
							if (o.type == 'imagebox' &&
								opts.e.layerX > o.left-(o.width/2) &&
								opts.e.layerX < o.left+(o.width/2) &&
								opts.e.layerY > o.top-(o.height/2) &&
								opts.e.layerY < o.top+(o.height/2)
							){
								var img_in = stage.canvas.getObjects().filter(function(im){
									return im.imagebox == o.id;
								});
								if (img_in.length > 0) {
									stage.canvas.setActiveObject(img_in[img_in.length-1]);
									opts.target = img_in[img_in.length-1];
									stage.canvas._setupCurrentTransform(opts.e, opts.target);
								}
							}
						});
					};
					
					if (opts.target !== null) {
						
						customdesign.ops.corner = opts.target.__corner;
						
						if (opts.target.group_pos) {
							
							customdesign.ops.original_pos = {};
							objs.map(function(o) {
								if (o.group_pos == opts.target.group_pos)
									customdesign.ops.original_pos[o.id] = [o.left, o.top]
							});
							
							if (Object.keys(customdesign.ops.original_pos).length === 1) {
								customdesign.ops.original_pos = null;
								opts.target.set({group_pos: null});
							}
						}
						
						if (opts.target.imagebox !== undefined) {
							customdesign.ops.limit_snap = objs.filter(function(o){return o.id == opts.target.imagebox;});
							if (customdesign.ops.limit_snap.length > 0)
								customdesign.ops.limit_snap = customdesign.ops.limit_snap[0];
							else customdesign.ops.limit_snap = stage.limit_zone;
						}
						
					} else { 
						customdesign.ops.corner = '';
						customdesign.ops.original_pos = null;
					}
					
					customdesign.ops.auto_snap = customdesign.get.el('auto-alignment').prop('checked');
					
				},

				'path:created' : function(path){

			        var stage = customdesign.stage();
					stage.limit_zone.visible = true;

					if (stage.bleed) {
						stage.bleed.set('visible', true);
						stage.crop_marks.set('visible', true);
					};
					
					customdesign.get.el('top-tools').attr({'data-view': 'drawing'});

					customdesign.stack.save();

				},

				'mouse:up': function(opts) {

					if (opts.e === undefined)
						return;
						
			        var stage = customdesign.stage(),
			        	actv = stage.canvas.getActiveObject(),
			        	onbox = null;

			        if (stage.canvas.isDrawingMode)
				    	return;
					
					stage.canvas.getObjects().map(function(o){
						if (o.type == 'imagebox') {
							if(
								opts.e.layerX > o.left-(o.boxbtn[0]/4) &&
								opts.e.layerX < o.left+(o.boxbtn[0]/4) &&
								opts.e.layerY > o.top-(o.boxbtn[1]/4) &&
								opts.e.layerY < o.top+(o.boxbtn[1]/4)
							) {
								onbox = o;
							}
						}
					});
					
					if (onbox !== null) {
						if (actv) {
							if (actv.type == 'image')
								return actv.set('imagebox', onbox.id);
						} else if (customdesign.ops.moved !== true)
							return customdesign.fn.imagebox_select_file(onbox);
					};
					
			        stage.lineX.css({display: 'none'});
					stage.lineY.css({display: 'none'});

					customdesign.ops.mousedown = false;
					stage.canvas.set('selection', true);

			        /*customdesign.fn.reversePortView();*/

					if (customdesign.ops.moved !== false) {

						if (customdesign.ops.downon !== null) {

							stage.lineX.hide();
							stage.lineY.hide();

						}

					};

					var active = stage.canvas.getActiveObject(),
						gactive = stage.canvas.getActiveGroup(),
						type = (active ? active.type : (gactive ? 'group' : 'standard'));
						
					customdesign.e.tools.attr({'data-view': type});
					
					if (!gactive) {
						setTimeout(customdesign.stack.save, 250);
					} else {
						var fh = true, fg = '';
						gactive._objects.map(function(o) {
							if (!o.get('group_pos')) {
								fh = false;
							} else {
								if (fg !== '' && o.get('group_pos') != fg)
									fh = false;
								fg = o.get('group_pos');
							}
						});
						$('#customdesign-top-tools ul[data-mode="group"]').attr({'data-grouped': fh ? 'true' : 'false'});
					};
					
					customdesign.ops.downon = null;
					customdesign.ops.moved = false;
					customdesign.ops.corner = '';
					customdesign.ops.original_pos = null;
					
				},

				'mouse:move': function(opts) {
					
					var stage = customdesign.stage(),
						zoom = stage.canvas.getZoom(),
						view = stage.canvas.viewportTransform,
						limit = customdesign.ops.limit_snap,
						gri = false;
					
					if (opts.target === null) {
						
						var objs = stage.canvas.getObjects(),
							actv = stage.canvas.getActiveObject(),
							vry = [];
						
						objs.map(function(o){
							if (
								o.imagebox !== undefined && 
								o.imagebox !== '' && 
								vry.indexOf(o.imagebox) === -1
							) vry.push(o.imagebox);
						});
						
						objs.map(function(o){
							
							if (o.type == 'imagebox' && (actv === null || actv === undefined || actv.type == 'image')) {
								
								let t = stage.canvas.viewportTransform,
									z = zoom/100,
									
									xx = o.left,
									yy = o.top,
									
									sx = (stage.canvas.width)/2,
									sy = (stage.canvas.height)/2;
								
								if(
									opts.e.layerX > xx-((zoom*o.boxbtn[0])/4) &&
									opts.e.layerX < xx+((zoom*o.boxbtn[0])/4) &&
									opts.e.layerY > yy-((zoom*o.boxbtn[1])/4) &&
									opts.e.layerY < yy+((zoom*o.boxbtn[1])/4)
								) {
									if (o.stroke != 'red') {
										o.set({stroke: 'red', strokeWidth: 2});
										stage.canvas.defaultCursor = 'pointer';
										stage.canvas.renderAll();
									}
								} else if (o.stroke == 'red'){
									o.set({stroke: '', strokeWidth: 0});
									stage.canvas.defaultCursor = 'default';
									stage.canvas.renderAll();
								};
								
								if (vry.indexOf(o.id) === -1)
									o.set('opacity', 1);
								
							}
						});
						
					};
					
					if (
						opts && opts.e && opts.e.shiftKey &&
						(customdesign.ops.mousedown === true || stage.canvas.isDrawingMode) &&
						zoom > 1 &&
						customdesign.ops.corner != 'br'
					) {
						// Move viewing mode
				        var units = 10;
				        var delta = new fabric.Point(opts.e.movementX, opts.e.movementY);

						stage.canvas.relativePan(delta);
				        return;
				    }

					if (customdesign.ops.downon === null)
						return;

					if (customdesign.ops.moved !== true)
						customdesign.ops.moved = true;

					if (customdesign.ops.auto_snap === true) {

						var el = {
								top: customdesign.ops.downon.top-(customdesign.ops.downon.height*customdesign.ops.downon.scaleY*0.5),
								left: customdesign.ops.downon.left-(customdesign.ops.downon.width*customdesign.ops.downon.scaleX*0.5),
								height: customdesign.ops.downon.height*customdesign.ops.downon.scaleY,
								width: customdesign.ops.downon.width*customdesign.ops.downon.scaleX,
							},
							lmx = limit.originX == 'left' ? (limit.width/2) : 0,
							lmy = limit.originY == 'top' ? (limit.height/2) : 0,
							yct = limit.left+lmx,
							xct = limit.top+lmy,
							xt = '',
							yl = '',
							xp = '',
							yp = '';
	
						if (Math.abs(customdesign.ops.downon.left-yct) <= 3) {
							yv = 'block';
							yl = yct;
							yp = 'center';
						}else if(Math.abs(el.left-yct) <= 3){
							yv = 'block';
							yl = yct;
							yp = 'left';
						}else if(Math.abs(el.left+el.width-yct) <= 3){
							yv = 'block';
							yl = yct;
							yp = 'right';
						}else yv = 'none';
	
						if (Math.abs(customdesign.ops.downon.top-xct) <= 3) {
							xv = 'block';
							xt = xct;
							xp = 'center';
						}else if(Math.abs(el.top-xct) <= 3){
							xv = 'block';
							xt = xct;
							xp = 'top';
						}else if(Math.abs(el.top+el.height-xct) <= 3){
							xv = 'block';
							xt = xct;
							xp = 'bottom';
						}else xv = 'none';
	
						if (yv === 'none' || xv === 'none') {
							stage.canvas.getObjects().map(function(obj){
								if (obj.visible !== false && obj.evented !== false && obj !== customdesign.ops.downon){
	
									ob = {
										top: obj.top-(obj.height*obj.scaleY*0.5),
										left: obj.left-(obj.width*obj.scaleX*0.5),
										height: obj.height*obj.scaleY,
										width: obj.width*obj.scaleX,
									};
	
									if (yv === 'none'){
										if (Math.abs(el.left- ob.left) <= 2){
											yl = ob.left;
											yv = 'block';
											yp = 'left';
										}else if (
											Math.abs(
												(el.left + el.width) - (ob.left + ob.width)
											) <= 2
										){
											yl = ob.left + ob.width;
											yv = 'block';
											yp = 'right';
										}else if (
											Math.abs(el.left - (ob.left+ob.width)) <= 2
										){
											yl = ob.left+ob.width;
											yv = 'block';
											yp = 'left';
										}else if (
											Math.abs((el.left + el.width) - ob.left) <= 2
										){
											yl = ob.left;
											yv = 'block';
											yp = 'right';
										}else if (Math.abs((el.left+(el.width/2)) - (ob.left+(ob.width/2))) <= 2){
											yl = ob.left+(ob.width/2);
											yv = 'block';
											yp = 'ycenter';
										}
									}
									if (xv === 'none'){
										if (
											Math.abs(el.top - ob.top) <= 2
										){
											xt = ob.top;
											xv= 'block';
											xp = 'top';
										}else if (
											Math.abs(
												(el.top + el.height) - (ob.top + ob.height)
											) <= 2
										){
											xt = ob.top + ob.height;
											xv = 'block';
											xp = 'bottom';
										}else if (
											Math.abs(el.top - (ob.top+ob.height)) <= 2
										){
											xt = ob.top+ob.height;
											xv = 'block';
											xp = 'top';
										}else if (
											Math.abs((el.top + el.height) - ob.top) <= 2
										){
											xt = ob.top;
											xv = 'block';
											xp = 'bottom';
										}else if (Math.abs((el.top+(el.height/2)) - (ob.top+(ob.height/2))) <= 2){
											xt = ob.top+(ob.height/2);
											xv = 'block';
											xp = 'ycenter';
										}
									}
								}
							});
						}
	
						stage.lineX.css({'top': ((xt*zoom)+view[5])+'px', 'display': xv});
						stage.lineY.css({'left': ((yl*zoom)+view[4])+'px', 'display': yv});
	
						if (yv == 'block') {
	
							switch (yp) {
								case 'center' :
									customdesign.ops.downon.set('left', limit.left+lmx);
								break;
								case 'left' :
									customdesign.ops.downon.set('left', yl+(el.width/2));
								break;
								case 'right' :
									customdesign.ops.downon.set('left', yl-(el.width/2));
								break;
								case 'ycenter' :
									customdesign.ops.downon.set('left', yl);
								break;
							}
							gri = true;
						}
	
						if (xv == 'block') {
	
							switch (xp) {
								case 'center' :
									customdesign.ops.downon.set('top', limit.top+lmy);
								break;
								case 'top' :
									customdesign.ops.downon.set('top', xt+(el.height/2));
								break;
								case 'bottom' :
									customdesign.ops.downon.set('top', xt-(el.height/2));
								break;
								case 'xcenter' :
									customdesign.ops.downon.set('top', xt);
								break;
							}
							gri = true;
						}
					
					};
					
					if (
						limit === stage.limit_zone &&
						customdesign.ops.downon.group_pos &&
						customdesign.ops.original_pos &&
						customdesign.ops.original_pos[customdesign.ops.downon.id] &&
						(
							
							customdesign.ops.downon.left != customdesign.ops.original_pos[customdesign.ops.downon.id][0] ||
							customdesign.ops.downon.top != customdesign.ops.original_pos[customdesign.ops.downon.id][1]
						)
					) {
						
						var oldpos = customdesign.ops.original_pos[customdesign.ops.downon.id];
					
						stage.canvas.getObjects().map(function(o) {
							if (
								o.group_pos == customdesign.ops.downon.group_pos && 
								o.id != customdesign.ops.downon.id
							) {
								o.set({
									left: customdesign.ops.original_pos[o.id][0] + (customdesign.ops.downon.left-oldpos[0]),
									top: customdesign.ops.original_pos[o.id][1] + (customdesign.ops.downon.top-oldpos[1]),
								});
							}
						});	
						gri = true;					
					}
					
					if (gri === true)
						stage.canvas.renderAll();

				},
				
				'after:render': function(e){
					customdesign.actions.do('after:render');
				}

			},

			do : {

				deactiveAll : function() {
					customdesign.stage().canvas.deactivateAll();
					customdesign.stage().canvas.renderAll();
					customdesign.e.tools.attr({'data-view': 'standard'});
					$('#customdesign-layers li.active').removeClass('active');
				}

			},
			
			roundRect : function (ctx, x, y, width, height, radius, fill, stroke) {
				
				if (typeof stroke == 'undefined') {
					stroke = true;
				};
				
				if (typeof radius === 'undefined') {
					radius = 5;
				};
				
				if (typeof radius === 'number') {
					radius = {tl: radius, tr: radius, br: radius, bl: radius};
				} else {
					var defaultRadius = {tl: 0, tr: 0, br: 0, bl: 0};
					for (var side in defaultRadius) {
						radius[side] = radius[side] || defaultRadius[side];
					}
				};
				
				
				ctx.beginPath();
				ctx.moveTo(x + radius.tl, y);
				ctx.lineTo(x + width - radius.tr, y);
				ctx.quadraticCurveTo(x + width, y, x + width, y + radius.tr);
				ctx.lineTo(x + width, y + height - radius.br);
				ctx.quadraticCurveTo(x + width, y + height, x + width - radius.br, y + height);
				ctx.lineTo(x + radius.bl, y + height);
				ctx.quadraticCurveTo(x, y + height, x, y + height - radius.bl);
				ctx.lineTo(x, y + radius.tl);
				ctx.quadraticCurveTo(x, y, x + radius.tl, y);
				ctx.closePath();
				if (fill) {
					ctx.fill();
				};
				
				if (stroke) {
					ctx.strokeStyle="red";
					ctx.stroke();
				};
				
			},
			
			clipto : function (ctx, obj) {

				if (!obj || !obj.canvas)
					return;
				
				var stage = customdesign.stage();
				
				if (stage.canvas.getActiveGroup())
					obj = stage.canvas.getActiveGroup();

				var centerPoint = obj.getCenterPoint(),
					clipRect = stage.limit_zone,
					scaleXTo = (1 / obj.scaleX),
					scaleYTo = (1 / obj.scaleY),
					skewXTo = -obj.skewX/52,
					skewYTo = -obj.skewY/52;
				
				if (obj.imagebox !== undefined && obj.imagebox !== '') {
					
					var bss = {},
						obs = stage.canvas.getObjects();
					
					obs.map(function(o) {
						if (o.type == 'imagebox')
							o.set('opacity', 1);
					});
						
					obs.map(function(o) {
						if (o.id == obj.imagebox) {
							clipRect = {
								left: o.left - (o.width/2),
								top: o.top - (o.height/2),
								strokeWidth: 1,
								width: o.width,
								height: o.height
							};
							o.set('opacity', 0.25);
						}
					});
					
					
				}
				
				if (obj.flipX)
					scaleXTo = -scaleXTo;
				if (obj.flipY)
					scaleYTo = -scaleYTo;
				
				
			    ctx.save();
			    ctx.translate(0, 0);
			    ctx.transform(1, skewYTo, 0, 1, 0, 0);
			    ctx.transform(1, 0, skewXTo, 1, 0, 0);
			    ctx.scale(scaleXTo, scaleYTo);
			    ctx.rotate((obj.angle * -1) * (Math.PI / 180));

				let x = (clipRect.left) - centerPoint.x + clipRect.strokeWidth,
			        y = (clipRect.top) - centerPoint.y + clipRect.strokeWidth,
			        w = clipRect.width - clipRect.strokeWidth,
			        h = clipRect.height - clipRect.strokeWidth;

			    ctx.beginPath();
			    ctx.roundRect(x, y, w, h, clipRect.radius ? clipRect.radius : 0);
			    ctx.fillStyle = 'transparent';
			    ctx.fill();
			    ctx.closePath();
			    ctx.restore();

			},

			sides : {},

			text : function(ops){

				if (ops.fontFamily && ops.fontFamily.indexOf('"') === -1)
					ops.fontFamily = '"'+ops.fontFamily+'"';
				
				if (customdesign.data.text_direction == '1') {	
					ops.originX = customdesign.data.rtl == '1' ? 'right' : 'left';
					ops.originY = 'top';
				};
				
				var fill_default = customdesign.get.color('invert');
			
				if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
					fill_default = customdesign.data.colors.split(',')[0];
					if (fill_default.indexOf(':') > -1)
						fill_default = fill_default.split(':')[1];
					fill_default = fill_default.split('@')[0];
				};
				
				ops.editable = (customdesign.data.rtl != '1');
				
				var limit = customdesign.stage().limit_zone,
				    _ops = $.extend({
				        left: limit.left + (limit.width/2),
				        top: limit.top + (limit.height/2),
				        angle: 0,
				        textAlign: 'center',
				        fill: fill_default,
						name: ops.text ? ops.text : 'Sample Text'
				    }, ops),
					object = new fabric.IText(ops.text ? ops.text : 'Sample Text', _ops);
			    
			    object.set({
					clipTo: function(ctx) {
						try{
							return customdesign.objects.clipto(ctx, object);
						}catch(ex){}
			        }
				});

				return object;

			},

			qrcode : function(text, color, callback) {

				var canvas = customdesign.tools.qrcode({
					text: text,
					foreground: color,
				});

				fabric.Image.fromURL(canvas.toDataURL(), function(image) {

					var stage = customdesign.stage();

					image.set({
						left: stage.limit_zone.left + (stage.limit_zone.width/2),
						top: stage.limit_zone.top + (stage.limit_zone.height/2),
						width: stage.limit_zone.width*0.7,
						height: image.height * ((stage.limit_zone.width*0.7)/image.width),
						fill: color,
						backgroundColor: customdesign.fn.invert(color),
						name: text,
						text: text,
						type: 'qrcode',
						clipTo: function(ctx) {
				            return customdesign.objects.clipto(ctx, image);
				        }
					});

					customdesign.design.layers.create({type: 'image', image: image});

					callback(image);

				});

			},

			customdesign : {

				'i-text' : function(ops, callback) {
					
					return callback(customdesign.objects.text(ops));
					
					
					ops.src = 'data:image/svg+xml;base64,'+btoa(customdesign.fn.buildText(ops));
					
					return this.svg(ops, callback);
					
					/*var svg_text = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="100" height="100" viewBox="0 0 100 100" xml:space="preserve"><text font-family="Roboto" font-size="30" font-weight="normal" style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(25,25,112);" direction="rtl" text-anchor="end"><tspan x="0" y="50" fill="#191970" direction="rtl" text-anchor="end">&#x0061;&#x0062;&#x0035;&#x0040;&#x0021;</tspan></text></svg>';
					
					svg_text = '<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 500 500">\
								    <path id="curve" fill="transparent" d="M73.2,148.6c4-6.1,65.5-96.8,178.6-95.6c111.3,1.2,170.8,90.3,175.1,97" />\
								    <text width="500" font-size="40">\
								      <textPath xlink:href="#curve">\
								        Dangerous Curves Ahead\
								      </textPath>\
								    </text>\
								  </svg>';
								  
					svg_text = '<svg width="140.453125" height="70.265625" viewBox="58.984375 0 140.453125 70.265625" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="0.843894627118865"><text fill="#FF0000" stroke="none" stroke-width="0" stroke-linecap="round" stroke-linejoin="round" x="" y="" text-anchor="start" font-size="24px" font-family="arial" pattclass="none" data-textcurve="180" data-itemzoom="1 1" data-textspacing="11"><textPath xlink:href="#textPath-item-0"><tspan dy="-11">Hello world</tspan></textPath></text></g><defs><path id="textPath-item-0" d="M 91.609375 70.1074415696873 A 37.5605665696873 37.5605665696873 0 0 1 166.7305081393746 70.1074415696873"></path></defs></svg>';
					
					ops.src = 'data:image/svg+xml;base64,'+btoa(svg_text);
					
					return this.image(ops, callback);*/
					
					ops.editable = false;
						
					callback(customdesign.objects.text(ops));
					
				},

				'curvedText' : function(ops, callback) {

					var limit = customdesign.stage().limit_zone;
					var fill_default = customdesign.get.color('invert');
				
					if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
						fill_default = customdesign.data.colors.split(',')[0];
						if (fill_default.indexOf(':') > -1)
							fill_default = fill_default.split(':')[1];
						fill_default = fill_default.split('@')[0];
					};
					ops = $.extend({

				        left: limit.left + (limit.width/2),
				        top: limit.top + (limit.height/2),
				        angle: 0,
				        textAlign: 'center',
				        fill: fill_default,
				        textAlign: 'center',
						radius: 50,
						spacing: 5

				    }, ops);

					var object = new fabric.CurvedText(ops.text ? ops.text : 'Sample Text', ops);

				    object.set({
						clipTo: function(ctx) {
				            try{
								return customdesign.objects.clipto(ctx, object);
							}catch(ex){}
				        }
					});

				    callback(object);

				},

				'image' : function(ops, callback) {
					
					if (ops.src.indexOf('.svg') == ops.src.length-4)
						return this.svg(ops, callback);
					
					var stage = customdesign.stage(),
						active = stage.canvas.getActiveObject(),
			        	replace_active = ops.replace,
			        	do_replace = (
				        	replace_active !== false && 
							active !== null && 
							active !== undefined && 
							typeof active.setElement == 'function' &&
							localStorage.getItem('CUSTOMDESIGN-REPLACE-IMAGE') == 'true'
						);
					
					if (
						do_replace &&
						ops.src.indexOf('.svg') !== ops.src.length-4 &&
						ops.src.indexOf('data:image/svg+xml;base64') === -1
					) return customdesign.fn.replace_image(ops.src, active);
					
					$('#CustomdesignDesign').attr({'data-processing': 'true', 'data-msg': 'Processing..'});
					
					let img = new Image();
					
					img.onerror = function() {
						customdesign.fn.notice(customdesign.i(33)+ops.src, 'error', 5000);
					    callback(null);
					};
					
					img.onload = function() {
						
						let  src_data = this.src;
						
						if (ops.user_upload === true) {
							
						   	src_data = customdesign.fn.check_upload_dimensions(this);
							
							if (src_data === null)
								return callback(null);
								
							delete ops.user_upload;
							
						};
						
						let iw = this.naturalWidth,
							ih = this.naturalHeight;
							
						ops.src = src_data;
							
						if (ops.src.indexOf('http') === 0) {
							
							let cv = document.createElement('canvas');
							
							cv.height = ih;
							cv.width = iw;
							cv.getContext('2d').drawImage(img, 0, 0);
							ops.src = cv.toDataURL('image/'+(ops.src.indexOf('.png') === ops.src.length-4 ? 'png' : 'jpeg'));
							img.onload = function() {
								customdesign.stage().canvas.renderAll();
							};
							img.src = ops.src;
							delete cv;
							
						};
					
				        var image = new fabric.Image(this),
				        	stage = customdesign.stage(),
				        	objs =  stage.canvas.getObjects(),
				        	ibx = null;
						
						delete ops.replace;
				        
				        var imbs = objs.filter(function(o3){return o3.type == 'imagebox'});
				        
				        if (imbs.length > 0) {
					        imbs.map(function(o) {
						        if (objs.filter(function(o3){return o3.imagebox == o.id}).length === 0) 
						        	ibx = o;
					        });
							if (ibx === null)
								ibx = imbs[0];
				        }
					        
						if (ops.width == undefined) {
							ops.width = stage.limit_zone.width*0.85;
							ops.height = ops.width*(ih/iw);
						};
						
						if (ops.height == undefined) {
							ops.height = stage.limit_zone.height*0.85;
							ops.width = ops.height*(iw/ih);
						};
						
						if (ops.evented === undefined) {
							
							if (ibx !== null && !do_replace) {
								
								objs.map(function(o) {
									if (o.imagebox == ibx.id && o.id != ops.id)
										stage.canvas.remove(o);
								});
								
								ops.width = ibx.width;
								ops.height = ih*(ibx.width/iw);
								ops.left = ibx.left;
								ops.top = ibx.top;
								
								if (ops.height < ibx.height) {
									ops.height = ibx.height;
									ops.width = iw*(ops.height/ih);
								};
								
								ibx.ibadded = new Date().getTime();
								ops.imagebox = ibx.id;
								
							} else {
								if (ops.width > stage.limit_zone.width*0.85) {
									ops.height = (stage.limit_zone.width*0.85)*(ops.height/ops.width);
									ops.width = stage.limit_zone.width*0.85;
								}
								if (ops.height > stage.limit_zone.height*0.85) {
									ops.width = (stage.limit_zone.height*0.85)*(ops.width/ops.height);
									ops.height = stage.limit_zone.height*0.85;
								}
							}	
						};
						
						image.set($.extend({
							left: stage.limit_zone.left + (stage.limit_zone.width/2),
							top: stage.limit_zone.top + (stage.limit_zone.height/2),
							width: ops.width,
							height: ops.height
						}, ops));
						
						
						/*
							Use the thumbnail on the editor for a large image
						*/
						
						if (
							ops.src.indexOf('data:image/svg+xml;base64') === -1 && /*Ignored SVG*/
							image.full_src === undefined &&
							(
								this.naturalWidth > stage.limit_zone.width ||	
								this.naturalHeight > stage.limit_zone.height
							)
						) {
							setTimeout(customdesign.fn.large_image_helper, 1, {
								w: img.naturalWidth,
								h: img.naturalHeight,
								ew: stage.limit_zone.width,
								eh: stage.limit_zone.height,
								iw: ops.width,
								ih: ops.height,
								el: img,
								obj: image,
								src: image.src
							});	
						};
						
						if ((ops.filters && ops.filters.length > 0)) {

							ops.filters.map(function(fil, ind){
								if (fil.color){
									ops.filters[ind] = new fabric.Image.filters.Tint({
								        color: fil.color,
								    });
							    }
							});

							image.set('filters', ops.filters);

							image.applyFilters(stage.canvas.renderAll.bind(stage.canvas));

						};

						image.set('clipTo', function(ctx) {
				            return customdesign.objects.clipto(ctx, image);
				        });
						
						if (do_replace) {
							
							var olds = {
								width: active.width,
								height: active.height,
								src: image.src,
								origin_src: image.src
							};
							
							if (
								image.src.indexOf('.svg') == image.src.length-4 ||
								image.src.indexOf('data:image/svg+xml;base64') === 0
							) {
								olds.type = 'svg';
							} else olds.type = 'image';
							
							active.setElement(image._element);
							active.set(olds);
							
							customdesign.ops.importing = false;
							customdesign.stack.save();
							
							customdesign.ops.set_active = active;
							
							callback(null);
					        
				        } else callback(image);

					};
					
					img.setAttribute('crossOrigin', 'anonymous');
					
					img.src = ops.src;
					
				},

				'text-fx' : function(ops, callback) {
					
					var newobj = customdesign.objects.text(ops);

					ops.width = newobj.width;
					ops.height = newobj.height;

					delete ops['type'];
					delete ops['clipTo'];

					if (ops['bridge'] === undefined) {
						ops['bridge'] ={
							curve: -2.5,
							offsetY: 0.5,
							bottom: 2.5,
							trident: false,
							oblique: false,
						}
					}

					var ls = ['angle', 'skewX', 'skewY', 'opacity'], ol = {};

					ls.map(function(l){
						ol[l] = ops[l];
						delete ops[l];
					});

					var textImage = new fabric.Text(ops.text.trim(), ops);
					var cacheTextImage = new Image();

					cacheTextImage.src = textImage.toDataURL();

					var rs = ['width', 'height', 'scaleX', 'scaleY', 'fontSize', 'stroke', 'strokeWidth'];

					rs.map(function(r){
						ops[r] = ops[r]*2;
					});
					
					textImage = new fabric.Text(ops.text.trim(), ops);
					var cacheTextImageLarge = new Image();
					cacheTextImageLarge.src = textImage.toDataURL();

					rs.map(function(r){
						ops[r] = ops[r]/2;
					});
					
					ls.map(function(l){
						ops[l] = ol[l];
					});

					fabric.Image.fromURL(textImage.toDataURL(), function(image) {

						ops['type'] = 'text-fx';
				        ops['cacheTextImage'] = cacheTextImage;
				        ops['cacheTextImageLarge'] = cacheTextImageLarge;
				        ops.height = ops.height*2.5;
						ops['clipTo'] = function(ctx) {
				            return customdesign.objects.clipto(ctx, image);
				        };

						var cdata = customdesign.fn.bridgeText(image._element, ops['bridge']);
						
						delete ops.stroke;
						delete ops.strokeWidth;
						
						image.set(ops);

						if ((ops.filters && ops.filters.length > 0)) {

							var stage = customdesign.stage();

							ops.filters.map(function(fil, ind){
								if (fil.color){
									ops.filters[ind] = new fabric.Image.filters.Tint({
								        color: fil.color,
								    });
							    }
							});

							image.set('filters', ops.filters);

							image.applyFilters(stage.canvas.renderAll.bind(stage.canvas));

						};


						var _w = ops.width,
							_h = ops.height;
						
						image.setSrc(cdata, function(){
							image.set({height: _h, width: _w});
							return callback(image);
						});
						
					});

				},

				'qrcode' : function(ops, callback) {

					this.image(ops, callback);

				},

				'svg' : function(ops, callback) {
					
					if (ops.src === undefined)
						return callback(null);
					
					var donow = function(ops) {
						
						if (ops.src && ops.src.indexOf('data:image/svg+xml;base64,') === 0) {
							
							var xsvg = atob(ops.src.split('base64,')[1]);
							
							xsvg = xsvg.replace('width="undefined"', '').replace('height="undefined"', '');
							
							var wrp = $('<div>'+xsvg+'</div>'),
								svg = wrp.find('svg').get(0),
								vb = svg.getAttribute('viewBox') ? 
									 svg.getAttribute('viewBox') : 
									 svg.getAttribute('viewbox');
									 
							vb = vb.replace(/\,/g, ' ').replace(/  /g, ' ').split(' ');
							
							if (!svg.getAttribute('width') || !svg.getAttribute('height')) {
								svg.setAttribute('width', vb[2]);
								svg.setAttribute('height', vb[3]);
							};
							
							if (ops.height === undefined)
								ops.height = ops.width*(vb[3]/vb[2]);
							
							ops.src = 'data:image/svg+xml;base64,'+btoa(wrp.html());
							
							delete wrp;
							delete svg;
							delete vb;
							
						};
						
						return customdesign.objects.customdesign.image(ops, callback);
						
						/*
						*	Apply a solution to fix SVG for FireFox
						*	Try to add width & height attributes in <svg>
						*/
						
						fabric.loadSVGFromURL(ops.src, function(objects, options) {
							
							delete ops.type;
							delete ops.width;
							delete ops.height;
							
					        var shape = fabric.util.groupSVGElements(objects, options),
					        	editzone = customdesign.stage().edit_zone;
							
					        if (ops.height === undefined) {
								ops.width = shape.width;
								ops.height = shape.height;
								if (ops.scaleX == 1 && ops.width > editzone.width) {
									ops.scaleX = (editzone.width*0.8)/ops.width;
									ops.scaleY = (editzone.width*0.8)/ops.width;
								};
							};
							
							shape.set(ops);
							
				       		shape.set('clipTo', function(ctx) {
					            return customdesign.objects.clipto(ctx, shape);
					        });
					        
					        callback(shape);
							
					    });
							
					};
						
					if (/*ops.paths === undefined && */ops.src.indexOf('http') === 0) {
						$.ajax({
							url: ops.src,
							method: 'GET',
							dataType: 'text',
							statusCode: {
								403: function(){
									customdesign.fn.notice(customdesign.i(33)+'(403) '+ops.src, 'error', 3500);
									callback(null);
								},
								404: function() {
									customdesign.fn.notice(customdesign.i(33)+'(404) '+ops.src, 'error', 3500);
									callback(null);
								}
							},
							success: function(res) {
								ops.src = 'data:image/svg+xml;base64,'+btoa(res);
								ops.fill = '';
								donow(ops);
							}
						});

					}else{
						
						donow(ops);
					}

				},
				
				'path' : function(ops, callback) {

					var limit = customdesign.stage().limit_zone,
						path = new fabric.Path(ops.path, $.extend({
					        left: limit.left + (limit.width/2),
					        top: limit.top + (limit.height/2),
					    }, ops));

					path.set('clipTo', function(ctx) {
				        return customdesign.objects.clipto(ctx, path);
				    });

				    path.set('fill', null);

					callback(path);

				},
				
				'path-group' : function(ops, callback) {
					return this.svg(ops, callback);
				},
				
				'imagebox' : function(ops, callback) {
					
					if (ops.src !== undefined)
						return this.image(ops, callback);
						
					var img = new Image(),
						st = customdesign.stage();
						
					ops = $.extend({
						width: st.limit_zone.width,
						height: st.limit_zone.height,
						left: st.limit_zone.left,
						top: st.limit_zone.top,
						border: 10,
						background: '#eee',
						button: customdesign.data.assets+'assets/images/imagebox-btn.png',
						imagebox: ''
					}, ops, true);
					
					ops.width -= (ops.border*2);
					ops.height -= (ops.border*2);
					//ops.top += ops.border;
					//ops.left += ops.border;
					
					ops.border = 0;
					
					ops.evented = false;
					ops.selectable = false;
					ops.lockMovementX = true;
					ops.lockMovementY = true;
					
					//ops.originX = 'left';
					//ops.originY = 'top';
					
					var canvas = document.createElement('canvas');
						ctx = canvas.getContext('2d'),
						
					canvas.width = (ops.width*2);
					canvas.height = (ops.height*2);
					
					ctx.fillStyle = ops.background;
					ctx.fillRect(0, 0, canvas.width, canvas.height);
					
					img.onload = function() {
						
						ops.boxbtn = [this.width, this.height];
							
						ctx.drawImage(this, 
							ops.width - (this.width/2),
							ops.height - (this.height/2),
							ops.boxbtn[0], ops.boxbtn[1]
						);
						
						ops.src = canvas.toDataURL('image/jpeg');
						
						delete canvas;
						delete ctx;
						
						return customdesign.objects.customdesign.image(ops, callback);
						
					};
					
					img.src = ops.button;
					
				}
				
			},
			
			icons : {
				
				init: function (){
				
					var maps = {
						'del': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="m405 137l-30-30-119 119-119-119-30 30 119 119-119 119 30 30 119-119 119 119 30-30-119-119z"></path></svg>'), 
						'rot': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="m295 66c-96 0-175 66-187 160l-81-16l80 118l118-79l-75-15c10-60 73-126 146-126c81 0 146 69 146 150c0 80-80 146-144 146l0 42c107 0 187-86 187-190c0-104-86-190-190-190z"></path></svg>'), 
						'rez': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="M96,96v128l50.078-50l9.014,9l183.286,183L288.3,416h128.2V288l-50.078,50l-128.2-128l-64.1-64L224.2,96H96z"/></svg>'), 
						'dou': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="m160 352l160 0l0-128l96 0l0 256l-256 0z m-160-320l0 320l128 0l0 160l320 0l0-320l-128 0l0-160z"></path></svg>'), 
						'gro': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ccc"><path d="m388 140l-31-31-140 139 31 31z m93-31l-233 231-92-91-30 31 122 123 264-263z m-481 171l123 123 31-31-122-123z"></path></svg>'),
						'wrot': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#777"><path d="m295 66c-96 0-175 66-187 160l-81-16l80 118l118-79l-75-15c10-60 73-126 146-126c81 0 146 69 146 150c0 80-80 146-144 146l0 42c107 0 187-86 187-190c0-104-86-190-190-190z"></path></svg>'), 
						'wrez': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#777"><path d="M96,96v128l50.078-50l9.014,9l183.286,183L288.3,416h128.2V288l-50.078,50l-128.2-128l-64.1-64L224.2,96H96z"/></svg>'), 
						'wdou': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#777"><path d="m160 352l160 0l0-128l96 0l0 256l-256 0z m-160-320l0 320l128 0l0 160l320 0l0-320l-128 0l0-160z"></path></svg>'), 
						'wgro': btoa('<svg width="512" height="512" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#777"><path d="m388 140l-31-31-140 139 31 31z m93-31l-233 231-92-91-30 31 122 123 264-263z m-481 171l123 123 31-31-122-123z"></path></svg>')
					};
					
					Object.keys(maps).map(function(i) {
						customdesign.objects.icons[i] = new Image();
						customdesign.objects.icons[i].src = 'data:image/svg+xml;base64,'+maps[i];
					});
				}
			}

		},
		
		design : {

			events : function(){

				var onInput = function(e){

					var c = customdesign.stage().canvas,
						a = c.getActiveObject(),
						callback = this.getAttribute('data-callback'),
						action = this.getAttribute('data-action'),
						ratio = parseFloat(this.getAttribute('data-ratio')) || 1,
						val = showInput(e, this);

					if (callback) {

						if (customdesign.design.nav.callback[callback])
							customdesign.design.nav.callback[callback](this, e, ratio);

					}else if (action && a && !e.isTrigger){
						a.set(action, val*ratio);
						c.renderAll();
					}

				},
					showInput = function(e, el) {

						if (!el)
							el = this;
	
						var val = el.value,
							unit = el.getAttribute('data-unit') || '',
							ratio = parseFloat(el.getAttribute('data-ratio')) || 1;
	
						if (el.getAttribute('data-range')) {
							el.getAttribute('data-range').split(',').map(function(m){
								if (Math.abs(val-parseFloat(m)) < 5)
									val = m;
							});
						}
	
						el.setAttribute('data-value', val+unit);
						
						if (el.parentNode.getAttribute('data-range') == 'helper')
							el.parentNode.setAttribute('data-value', val+unit);
						
						return val;
	
					};

				customdesign.trigger({

					el: $('#CustomdesignDesign'),

					events: {

						'input[type="range"][data-view="customdesign"]:input': showInput,
						'input[type="range"][data-action]:input, input[type="range"][data-callback]:input': onInput,
						'input[type="range"][data-callback="textFX"]:change': 'textFX',
						'#customdesign-stroke-fix-colors li': 'strokeColor',

						'div#customdesign-left>div.customdesign-left-nav-wrp>ul.customdesign-left-nav li[data-tab]': 'leftNav',
						'#customdesign-general-status': 'general_status',
						'div#customdesign-left #customdesign-side-close': 'close_side',
						'svg#customdesign-nav-file': 'resp_file',
						'#customdesign-stage-nav': 'stages',
						'#customdesign-cliparts': 'cliparts',
						'#customdesign-uploads header button': 'upload_nav',
						'#customdesign-left .customdesign-x-thumbn:mouseover,#customdesign-left .customdesign-x-thumbn:mouseout': 'x_thumbn_preview',
						'#customdesign-left button[data-func="show-categories"]': 'x_thumbn_categories',
						'#customdesign-cliparts-list:scroll': 'cliparts_more',
						'#customdesign-templates-list:scroll': 'templates_more',
						'#customdesign-uploads div[data-tab="internal"]:scroll': 'images_more',
						'#customdesign-shapes:scroll': 'shapes_more',
						
						'.customdesign-tab-body-wrp .customdesign-xitems-list:scroll': customdesign.xitems.scroll_more,

						'#customdesign-saved-designs:scroll': 'designs_more',

						'#customdesign-templates-search-inp:click,#customdesign-templates-search-inp:keydown,#customdesign-templates-search-categories:change': 'templates_search',
						'#customdesign-cliparts-search-inp:click,#customdesign-cliparts-search-inp:keydown,#customdesign-cliparts-search-categories:change': 'cliparts_search',
						'.customdesign-xitems-search>input:click,.customdesign-xitems-search>input:keydown,.customdesign-xitems-search>input:change': customdesign.xitems.search,

						'div#customdesign-top-tools>ul.customdesign-top-nav>li[data-tool], div#customdesign-navigations ul li[data-tool]': 'topTools',

						'input#customdesign-zoom[type="range"]:input, #customdesign-zoom-wrp i[data-zoom], #customdesign-zoom-wrp:mousewheel': 'doZoom',
						'ul[data-mode="text"] .text-format': 'textFormat',

						'.customdesign-edit-text:input': 'editText',
						'#customdesign-text-mask-guide': function(){
							customdesign.tools.lightbox({
								content: '<img src="'+customdesign.data.assets+'/assets/images/text-mask-guide.jpg" />',
								onload: function(tmpl){
									tmpl.children('div').addClass('parent-scroll-mobile').find('#customdesign-lightbox-content').addClass('scroll-mobile');
									return tmpl;
								}
							});
						},

						'#customdesign-flip-x:change, #customdesign-flip-y:change': 'flip',
						'#customdesign-lock-position:change': 'lock_position',
						'#customdesign-reset-transform': 'resetTransform',

						'input#customdesign-curved:change': 'enableCurved',
						'input#customdesign-fill:input,input#customdesign-fill:change': 'fillColor',
						'span.customdesign-save-color': 'saveColor',
						'input#customdesign-stroke:input, input#customdesign-stroke:change': 'fillStroke',
						
						'input#customdesign-svg-fill:input,input#customdesign-svg-fill:change': 'svgFillColor',
						'#customdesign-svg-colors [data-func]': 'svgFuncs',
						
						'li[data-tool="arrange"] button[data-arrange]' : 'doArrange',
						'.customdesign-more-fonts': 'load_fonts',
						'#customdesign-fonts' : 'select_font',

						'#customdesign-upload-form input[type="file"]:change': function(){
							customdesign.fn.process_files(this.files);
						},

						'#customdesign-design-undo': customdesign.stack.back,
						'#customdesign-design-redo': customdesign.stack.forward,
						'#customdesign-save-btn': customdesign.tools.save,

						'#customdesign-discard-drawing': 'exit_drawing',
						'#customdesign-text-effect img[data-effect]': 'text_effect',
						'#customdesign-text-fx-trident:change': 'textFX',
						'input[data-image-fx][type="range"]:change': 'imageFX',

						'#customdesign-drawing-color:change': function(e){
							customdesign.design.nav.callback.drawing(e);
						},
						'#customdesign-auto-alignment:change, #customdesign-template-append:change, #customdesign-replace-image:change': 'options',

						'button[data-func="update-text-fx"]': customdesign.fn.update_text_fx,
						'#customdesign-bug button.submit': 'bug_submit',
						
						'#customdesign-image-fx-mode:change': 'selectImageFX',
						'#customdesign-image-fx-fx>li[data-fx]': 'imageColorFX',

						'#customdesign-saved-designs': 'saved_designs',
						'#customdesign-designs-search input:input': 'saved_designs_search',
						'#customdesign-languages li': 'change_lang',
						'button#customdesign-change-product, button#customdesign-select-product': 'change_product',

						'#customdesign-file-nav li[data-func]': 'fileNav',
						'#customdesign-print-nav .doPrint:change, #customdesign-print-nav button[data-func]': 'doPrint',
						'.customdesign-tabs-nav': 'nav',
						'#customdesign-shares-wrp': 'doShare',
						
						'#customdesign-cart-items': 'my_cart',
						'a[data-view="cart-details"]': customdesign.render.cart_details,

					},

					leftNav: function(e) {

						var tab = this.getAttribute('data-tab'),
							stage = customdesign.stage();
						
						if (stage === undefined || stage.canvas === undefined)	
							return;
							
						/*customdesign.tools.discard();*/

						if (tab == 'drawing') {
							stage.canvas.isDrawingMode = true;
							stage.limit_zone.visible = true;
							var fill_default = customdesign.get.color('invert');
				
							if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
								fill_default = customdesign.data.colors.split(',')[0];
								if (fill_default.indexOf(':') > -1)
									fill_default = fill_default.split(':')[1];
								fill_default = fill_default.split('@')[0];
							};
							stage.canvas.freeDrawingBrush.color = fill_default;
							customdesign.get.el('top-tools').attr({'data-view': 'drawing'});
						} else if (tab == 'uploads') {
							if (customdesign.get.el('external-images').hasClass('active')) {
								$('#customdesign-external-images iframe').each(function(){
									this.contentWindow.postMessage({
										action : 'refresh'
									}, "*");
								});
							}
						} else if (stage && stage.canvas) {
							stage.canvas.isDrawingMode = false;
							stage.limit_zone.visible = false;
							customdesign.get.el('top-tools').attr({'data-view': 'standard'});
							stage.canvas.renderAll();
						};

						if (this.getAttribute('data-load')) {
							if (typeof customdesign.design.nav.load[this.getAttribute('data-load')] == 'function')
								customdesign.design.nav.load[this.getAttribute('data-load')](e);
							this.removeAttribute('data-load');
						};

						$('#customdesign-left .customdesign-tab-body-wrp.active,#customdesign-left ul.customdesign-left-nav li[data-tab].active').removeClass('active');
						$('#customdesign-left [data-view="preactive"]').removeAttr('data-view');
						$(this).addClass('active').prev('li[data-tab]').attr({'data-view': 'preactive'});

						$('#customdesign-'+this.getAttribute('data-tab')).addClass('active');
						$('#customdesign-side-close').addClass('active');
						
						if (
							this.getAttribute('data-callback') &&
							typeof customdesign.design.nav.callback[this.getAttribute('data-callback')] == 'function'
						)
							customdesign.design.nav.callback[this.getAttribute('data-callback')](e);

					},
					
					general_status: function(e) {
						
						var func = e.target.getAttribute('data-func');

						var funcParent = $(e.target).parent().attr('data-func');
						
						if (!func && !funcParent){
							return;
						}

						if(!func && funcParent){
							func = funcParent;
						}
						
						e.preventDefault();
							
						switch (func) {
							
							case 'cancel-cart': 
								
								customdesign.fn.set_url('cart', null);
								
								customdesign.get.el('general-status').html(
									'<span>\
										<text>\
											<i class="customdesignx-android-alert"></i> '+
											customdesign.i(184)+
										'</text>\
										<a href="#clear-designs" data-btn="cancel" data-func="clear-designs">\
											'+customdesign.i(185)+'\
										</a>\
									</span>'
								);
								
								customdesign.render.cart_change();

							break;
							
							case 'cancel-design': 
								
								customdesign.get.el('general-status').html(
									'<span>\
										<text>\
											<i class="customdesignx-android-alert"></i> '+
											customdesign.i(184)+
										'</text>\
										<a href="#clear-designs" data-btn="cancel" data-func="clear-designs">\
											'+customdesign.i(185)+'\
										</a>\
									</span>'
								);
								
								customdesign.render.cart_change();

							break;
							
							case 'save-design':
								customdesign.design.my_designs.pre_save();
							break;
							
							case 'clear-designs':
								customdesign.tools.clearAll();
								customdesign.render.cart_change();
								customdesign.get.el('general-status').html('');
							break;
						}
						
					},
					
					close_side: function(e) {
						$(this).removeClass('active');
						$('#customdesign-left ul.customdesign-left-nav li.active, .customdesign-tab-body-wrp.active').removeClass('active');
					},
					
					resp_file: function() {
						
						if (!$(this).prev().hasClass('active')){
							$(this).prev().addClass('active');
							$(this).find('#__m').hide();
							$(this).find('#__x').show();
						}else{
							$(this).prev().removeClass('active');
							$(this).find('#__m').show();
							$(this).find('#__x').hide();
						}
						
					},
					
					stages: function(e) {
						
						var stage = e.target.getAttribute('data-stage'),
							wrp = $(this),
							prev = $(this).hasClass('preview-designs');
						
						customdesign.do_action('stage_nav_click', e);
						
						if (e.target.id == 'customdesign-stage-nav' && prev) {
							wrp.removeClass('preview-designs').removeClass('stages-expand');
							wrp.find('li[data-stage].active').removeClass('active');
							wrp.find('li[data-stage="'+customdesign.current_stage+'"]').addClass('active');
							return;
						};
						
						if (!stage) {
							
							var nav = e.target.getAttribute('data-nav') || 
									  e.target.parentNode.getAttribute('data-nav') || 
									  e.target.parentNode.parentNode.getAttribute('data-nav'),
								actv = customdesign.get.el('stage-nav').find('li.active');
							
							if (nav && nav != 'func') {
								if (nav == 'prev' && actv.prev('li[data-stage]'))
									stage = actv.prev('li[data-stage]').data('stage');
								else if (nav == 'next' && actv.next('li[data-stage]'))
									stage = actv.next('li[data-stage]').data('stage');
							}
							
								
						} else if (!wrp.hasClass('stages-expand') && !prev){
							wrp.addClass('stages-expand');
							return;
						};
						
						if (
							!stage || 
							(stage == customdesign.current_stage && !prev) || 
							!customdesign.data.stages[stage]
						)return;
						
						if (wrp.hasClass('preview-designs')) {
							customdesign.fn.stage_nav(stage);
							return;	
						};
						
						wrp.removeClass('stages-expand preview-designs');
						
						customdesign.active_stage(stage, function() {
							customdesign.design.layers.build();
							customdesign.get.el('zoom').val(customdesign.stage().canvas.getZoom()*100).trigger('input');
							customdesign.e.tools.attr({'data-view': 'standard'});
						});

					},

					cliparts: function(e) {

						var el = e.target.getAttribute('data-act') ? $(e.target) : $(e.target).closest('[data-act]'),
							act = null;

						if (el.get(0))
							act = el.data('act');

						if (!act) return;

						switch (act) {

							case 'category' :

								var tm = customdesign.get.el('cliparts-list');

								customdesign.get.el('cliparts').find('.customdesign-cliparts-category.selected').removeClass('selected');
								el.addClass('selected');
								customdesign.get.el('cliparts').addClass('selected');

								customdesign.get.el('cliparts-list')
									.data({'category': el.data('category')})
									.html('<header>\
												<span data-act="back" title="'+customdesign.i(43)+'">\
													<i class="customdesignx-android-arrow-back"></i>\
												</span>\
												<span class="customdesign-category-title">'+customdesign.i(44)+'</span>\
											</header><i class="customdesign-spinner white x3 mt2"></i>');

								customdesign.post({
									action: 'cliparts',
									category: el.data('category'),
									q: customdesign.ops.cliparts_q,
									index: 0
								});
								customdesign.ops.cliparts_index = 0;
							break;

							case 'back' :
								customdesign.get.el('cliparts').find('.customdesign-cliparts-category.selected').removeClass('selected');
								customdesign.get.el('cliparts').removeClass('selected');
								customdesign.get.el('cliparts-list').data({'category': ''});
							break;
						}

					},
					
					do_search: function(type) {
						
						customdesign.ops[type+'_index'] = 0;
						customdesign.ops[type+'_loading'] = false;

						customdesign.get.el(type+'-list').find('ul').html('');
						customdesign.get.el(type+'-list').trigger('scroll');
					
					},
					
					templates_search: function(e) {
						
						if (e.type == 'click') {
							setTimeout(function(el){
								if (customdesign.ops.templates_q != el.value && el.value === '') {
									customdesign.ops.templates_q = el.value;
									e.data.do_search('templates');
								}
							}, 100, this);
						}
						
						if (this.tagName == 'INPUT' && e.keyCode !== 13)
							return;

						if (this.tagName == 'INPUT')
							customdesign.ops.templates_q = this.value;

						e.data.do_search('templates');

					},
					
					cliparts_search: function(e) {
						
						if (e.type == 'click') {
							setTimeout(function(el){
								if (customdesign.ops.cliparts_q != el.value && el.value === '') {
									customdesign.ops.cliparts_q = el.value;
									e.data.do_search('cliparts');
								}
							}, 100, this);
						}
						
						if (this.tagName == 'INPUT' && e.keyCode !== 13)
							return;

						if (this.tagName == 'INPUT')
							customdesign.ops.cliparts_q = this.value;
						
						e.data.do_search('cliparts');

					},
					
					upload_nav : function(e) {
						
						var wrp = $(this).closest('#customdesign-uploads'),
							nav = this.getAttribute('data-nav'),
							tab = wrp.find('div[data-tab="'+nav+'"]');
						
						if (nav == 'external') {
							if (tab.find('iframe').length === 0)
								tab.html('<iframe src="https://services.customdesign.com/images/"></iframe>');
							else if($(this).hasClass('active')) {
								tab.scrollTop(0);
								tab.find('iframe').get(0).contentWindow.postMessage({
									action : 'scrollTop'
								}, "*");
							}
						}
						
						wrp.find('header button.active, div[data-tab].active').removeClass('active');
						
						$(this).addClass('active');
						tab.addClass('active');
						
						e.preventDefault();
							
					},
					
					x_thumbn_preview : function(e) {

						if (
							e.target.tagName == 'I' &&
							e.target.getAttribute('data-info') &&
							e.target.parentNode.getAttribute('data-ops')
						) {
							if (
								e.type == 'mouseover' &&
								customdesign.ops.drag_start === null
							) {

								if (customdesign.ops.xtc_timer !== undefined)
									clearTimeout(customdesign.ops.xtc_timer);
								try {
									
									var ops = e.target.parentNode.getAttribute('data-ops');
									
									if (customdesign.xitems.ops[ops] !== undefined)
										ops = $.extend([], customdesign.xitems.ops[ops], true);
									else ops = JSON.parse(ops);
									
									ops = ops[0];
									
								} catch(ex) {
									console.warn(ex.message);
									console.log(ex);
									return;
								};

								var price = (
										(ops.type == 'image' || ops.type == 'template') ? 
										(ops.price > 0) ? customdesign.fn.price(ops.price) : 
										customdesign.i(100) : ''
									),
									tags = (
										ops.type == 'upload' ? customdesign.i(84): ops.cates != 'null' && ops.cates != '' ? ops.cates : (
											ops.tags != '' && ops.tags != 'null' ? ops.tags : ''
										)
									),
									do_view = function() {
										
										if (ops.component !== undefined)
											ops.url = customdesign.xitems.resources[ops.component].url[ops.id];
											
										customdesign.get.el('x-thumbn-preview').show().find('>div').html('<img src="'+ops.url+'" />');
										customdesign.get.el('x-thumbn-preview').find('>header').html(
											(ops.name ? ops.name : ops.url.split('/').pop().substr(0, 50))
											+'<span>'+price+'</span>'
										);
										
										if (tags !== '')
											customdesign.get.el('x-thumbn-preview').find('>footer').show().html(customdesign.i(105) +' '+tags);
										else
											customdesign.get.el('x-thumbn-preview').find('>footer').hide().html('');
											
									},
									template_view = function() {
										
										var s = customdesign.stage(), 
											c = customdesign.get.color();
										
										customdesign.get.el('x-thumbn-preview').show().find('>div').html(
											'<div class="customdesign-template-preview">\
												<img style="background:'+c+'" src="'+s.product._element.src+'" />\
												<div class="customdesign-tp-limit"></div>\
											</div>'
										);
										
										customdesign.get.el('x-thumbn-preview').find('img').on('load', function(){
											
											var el = $(this).parent().find('.customdesign-tp-limit'),
												ratio = s.product_width ? this.offsetWidth/s.product_width : 1,
												w = Math.round(s.edit_zone.width*ratio),
												h = Math.round(s.edit_zone.height*ratio),
												t = (s.edit_zone.top*ratio),
												l = (s.edit_zone.left*ratio);
											
											el.css({
												marginLeft: l+'px',
												marginTop: t+'px',
												height: (h%2 != 0 ? h+1 : h)+'px',
												width: (w%2 != 0 ? w+1 : w)+'px',
												borderColor: customdesign.fn.invert(c)
											}).html('<img src="'+ops.screenshot+'" />');
											
										});
										
										customdesign.get.el('x-thumbn-preview').find('>header').html(
											(ops.name ? ops.name : ops.url.split('/').pop().substr(0, 50))
											+'<span>'+price+'</span>'
										);
										if (tags !== '')
											customdesign.get.el('x-thumbn-preview').find('>footer').show().html(customdesign.i(105) +' '+tags);
										else
											customdesign.get.el('x-thumbn-preview').find('>footer').hide().html('');
									};
								
								if (ops.type == 'template') {
									return template_view();
								}
									
								if (ops.url === undefined) {
									ops.url = customdesign.cliparts.storage[ops.id] || customdesign.cliparts.uploads[ops.id];
								}
								
								if (ops.url !== undefined && ops.url.indexOf('dumb-') === 0) {
									customdesign.indexed.get(ops.url.split('dumb-')[1], 'dumb', function(res){
										if (res !== null && res !== undefined) {
											customdesign.cliparts.uploads[ops.id] = res[0];
											ops.url = res[0];
											do_view();
											delete res;
										} else {
											customdesign.fn.notice(customdesign.i(165));
										}
									});
									ops.url = '';
								}
								
								do_view();

							}else{

								customdesign.ops.xtc_timer = setTimeout(function(){
									customdesign.get.el('x-thumbn-preview').hide();
								}, 350);

							}
						}

					},
					
					x_thumbn_categories : function(e) {
						
						var wrp = customdesign.get.el('x-thumbn-preview'),
							type = this.getAttribute('data-type');
						
						if (customdesign.ops.xtc_timer !== undefined)
							clearTimeout(customdesign.ops.xtc_timer);
						
						if (wrp.css('display') == 'block' && wrp.find('div.customdesign-categories-wrp').length !== 0)
							return wrp.hide();
						
						wrp.show().find('>div').html('');
						wrp.find('>header').html('<strong>'+customdesign.i(56)+'<i class="customdesignx-android-close close"></i></strong>');
						wrp.find('>footer').html('').hide();
						
						customdesign.render.categories(type);
							
					},
					
					templates_more: function(e) {

						if (customdesign.ops.templates_loading === true)
							return;

						if (this.scrollTop + this.offsetHeight >= this.scrollHeight/* - 100*/) {
							customdesign.post({
								action: 'templates',
								category: customdesign.ops.templates_category,
								q: customdesign.ops.templates_q,
								index: customdesign.ops.templates_index
							});
							customdesign.get.el('templates-list').append('<i class="customdesign-spinner white x3 mt1 mb1"></i>');
							customdesign.ops.templates_loading = true;
						}


					},
					
					cliparts_more: function(e) {

						if (customdesign.ops.cliparts_loading === true)
							return;

						if (this.scrollTop + this.offsetHeight >= this.scrollHeight/* - 100*/) {
							customdesign.post({
								action: 'cliparts',
								category: customdesign.ops.cliparts_category,
								q: customdesign.ops.cliparts_q,
								index: customdesign.ops.cliparts_index
							});
							customdesign.get.el('cliparts-list').append('<i class="customdesign-spinner white x3 mt1 mb1"></i>');
							customdesign.ops.cliparts_loading = true;
						}


					},

					images_more : function(e) {

						if (customdesign.ops.images_loading === true)
							return;

						if (this.scrollTop + this.offsetHeight >= this.scrollHeight - 100) {
							
							customdesign.ops.images_loading = true;
							customdesign.indexed.list(function(data){
								customdesign.cliparts.import(data.id, {
									url: 'dumb-'+data.id,
									thumbn: data.thumbn,
									name: data.name,
									save: false
								});
								customdesign.ops.uploads_cursor = data.id;
								delete data;
							}, 'uploads', function(st){
								customdesign.ops.images_loading = false;
								if (st == 'done') {
									$('#customdesign-uploads').off('scroll');
								}
							});
						}
					},

					shapes_more: function(e) {

						if (customdesign.ops.shapes_loading === true)
							return;

						if (this.scrollTop + this.offsetHeight >= this.scrollHeight - 100) {
							customdesign.post({
								action: 'shapes',
								index: customdesign.ops.shapes_index
							});
							customdesign.get.el('shapes').append('<i class="customdesign-spinner white x3 mt3 mb1"></i>');
							customdesign.ops.shapes_loading = true;
						}
					},

					designs_more : function(e) {
						
						if (customdesign.ops.designs_loading === true)
							return;
							
						if (this.scrollTop + this.offsetHeight >= this.scrollHeight - 100) {
							customdesign.ops.designs_loading = true;
							customdesign.ops.designs_cursor = $('#customdesign-saved-designs>li[data-id]:not([data-id="new"])').last().data('id');
							customdesign.indexed.list(function(data){
								customdesign.render.my_designs(data);
								customdesign.ops.designs_cursor = data.id;
								delete data;
							}, 'designs', function(st){
								customdesign.ops.designs_loading = false;
								if (st == 'done') {
									$('#customdesign-my-designs').off('scroll');
								}
							});
						}
					},

					dragPop : function(e) {

						if (e.target.tagName != 'H3')
							return;

						var el = this;

						el.dragging = true;

						if (el.dragSetup === undefined) {

							$(document).on('mousemove', function(e){

								if (!el.dragging || customdesign.e.tools.hasClass('minisize'))
									return;

								var scroll = customdesign.get.scroll();

								customdesign.e.tools.css({
									top: (e.clientY - el.rect.clientY + el.rect.top)+'px',
									left: (e.clientX - el.rect.clientX + el.rect.left)+'px',
								});


							}).on('mouseup', function(e){
								el.dragging = false;
							});

							el.dragSetup = true;

						}

						var rect = document.querySelector('#customdesign-workspace').getBoundingClientRect(),
							scroll = {
									top: (customdesign.body.scrollTop?customdesign.body.scrollTop:customdesign.html.scrollTop),
									left: (customdesign.body.scrollLeft?customdesign.body.scrollLeft:customdesign.html.scrollLeft)
								};

						el.rect = {
							left: customdesign.e.tools.offset().left-rect.left-scroll.left,
							top: customdesign.e.tools.offset().top-rect.top-scroll.top,
							clientX: e.clientX,
							clientY: e.clientY
						};

					},

					topTools : function(e) {
						
						var act = this.getAttribute('data-tool'),
							cb = this.getAttribute('data-callback');
						
						if (this.getAttribute('data-load')) {
							if (typeof customdesign.design.nav.load[this.getAttribute('data-load')] == 'function')
								customdesign.design.nav.load[this.getAttribute('data-load')](e);
							this.removeAttribute('data-load');
						}
						
						if (act == 'callback' && cb && typeof customdesign.design.nav.callback[cb] == 'function') {
							return customdesign.design.nav.callback[cb](this, e);
						};
						
						if (
							(!act || $(e.target).closest('[data-view="sub"]').length > 0) &&
							(
								e.target.className.toString().indexOf('close') === -1 ||
								e.target.getAttribute('data-noclose')
							)
						) {
							if (act && e.data[act] && typeof e.data[act] == 'function')
								e.data[act](e);
							return;
						}

						customdesign.fn.navigation(this, e);
						
						if (cb && typeof customdesign.design.nav.callback[cb] == 'function')
							customdesign.design.nav.callback[cb](this, e);

					},
					
					position : function(e) {

						var pos = e.target.getAttribute('data-position') || 
								  e.target.parentNode.getAttribute('data-position') ||
								  e.target.parentNode.parentNode.getAttribute('data-position'),
							stage = customdesign.stage(),
							limit = stage.limit_zone,
							active = stage.canvas.getActiveObject() || stage.canvas.getActiveGroup();
						
						if (active.imagebox !== undefined && active.imagebox !== '') {
							var imb = stage.canvas.getObjects().filter(function(o) {
										return o.type == 'imagebox' && o.id == active.imagebox;
									});
							if (imb.length > 0)
								limit = {
									width: imb[0].width,
									height: imb[0].height,
									top: imb[0].top-(imb[0].height/2),
									left: imb[0].left-(imb[0].width/2),
								};
						};
						
						if (!active || !pos)
							return;

						var left = active.left,
							top = active.top;

						switch (pos) {

							case 'tl' :
								left = limit.left + (active.getWidth()/2);
								top = limit.top + (active.getHeight()/2);
							break;
							case 'tc' :
								left = limit.left+(limit.width/2);
								top = limit.top+(active.getHeight()/2);
							break;
							case 'tr' :
								left = limit.left+limit.width-(active.getWidth()/2);
								top = limit.top + (active.getHeight()/2);
							break;


							case 'ml' :
								left = limit.left + (active.getWidth()/2);
								top = limit.top+(limit.height/2);
							break;
							case 'mc' :
								left = limit.left+(limit.width/2);
								top = limit.top+(limit.height/2);
							break;
							case 'mr' :
								left = limit.left+limit.width-(active.getWidth()/2);
								top = limit.top+(limit.height/2);
							break;


							case 'bl' :
								left = limit.left + (active.getWidth()/2);
								top = limit.top+limit.height-(active.getHeight()/2);
							break;
							case 'bc' :
								left = limit.left+(limit.width/2);
								top = limit.top+limit.height-(active.getHeight()/2);
							break;
							case 'br' :
								left = limit.left+limit.width-(active.getWidth()/2);
								top = limit.top+limit.height-(active.getHeight()/2);
							break;

							case 'cv' :
								top = limit.top+(limit.height/2);
							break;

							case 'ch' :
								left = limit.left+(limit.width/2);
							break;

						};

						if (active.group_pos) {
							stage.canvas.getObjects().map(function(o) {
								if (o.group_pos && o.id != active.id) {
									o.set({
										left: o.left + (left-active.left),
										top: o.top + (top-active.top),
									});
								}
							});
						};

						active.set({top: top, left: left});
						active.setCoords();
						stage.canvas.renderAll();

					},

					doZoom : function(e){

						e.preventDefault();
						
						var s = customdesign.stage();
						
						if (!s)
							return;
						
						var c = s.canvas,
							val = parseInt(customdesign.get.el('zoom').val());
						
						if (e.originalEvent !== undefined && e.originalEvent.deltaY !== undefined) {
							val -= e.originalEvent.deltaY;
							if (val < 50)
								val = 50;
							if (val > 250)
								val = 250;
							e.preventDefault();
							return customdesign.get.el('zoom').val(val).trigger('input');
						}
						
						if (this.tagName == 'I') {
							if (this.getAttribute('data-zoom') == 'out')
								val -= 10;
							else val += 10;
							if (val < 50)
								val = 50;
							if (val > 250)
								val = 250;
							customdesign.get.el('zoom').val(val).trigger('input');
							return false;
						}
						
						[75, 100, 125, 150, 175, 200, 225].map(function(m){
							if (Math.abs(val-m) < 5)
								val = m;
						});

						this.setAttribute('data-value', val+'%');
						this.parentNode.setAttribute('data-value', val+'%');
						
						
						var wrp = customdesign.get.el('stage-'+customdesign.current_stage);

						if (!wrp.data('w'))
							wrp.data({'w': wrp.width(), 'h': wrp.height()});

						var w = wrp.data('w')*(val/100),
							h = wrp.data('h')*(val/100),
							v = c.viewportTransform;
						
						val /= 100;
						
						c.zoomToPoint(
							new fabric.Point(
								(s.limit_zone.left+(s.limit_zone.width/2)),
								(s.limit_zone.top+(s.limit_zone.height/2))
							), 
							val
						);
						
						if (val >= 1) {
							customdesign.fn.reversePortView(false);
						}
						
					},

					moveZoom : function(e) {

						var wrp = this.parentNode;

						var onstopmove = function(e){
							document.removeEventListener('mouseup', onstopmove, false);
							wrp.removeEventListener('mousemove', customdesign.fn.onZoomThumnMove, false);
						};
						customdesign.ops.preventClick = true;
						wrp.addEventListener('mousemove', customdesign.fn.onZoomThumnMove, false);
						document.addEventListener('mouseup', onstopmove, false);


					},

					wheelZoom : function(e) {

						var zoom = parseFloat(customdesign.get.el('zoom').val());

						zoom +=  e.originalEvent.wheelDelta*0.15;

						if (zoom < 100)
							zoom = 100;
						else if (zoom > 250)
							zoom = 250;

						customdesign.get.el('zoom').val(zoom).trigger('input');

						e.preventDefault();

					},

					fillColor : function(e){

						var c = customdesign.stage().canvas,
							a = c.getActiveObject();

						/*if (a.type == 'text-fx' && e.isTrigger !== undefined)
							return;*/

						if (a && a.fill !== this.value) {

							if (a.type == 'image' || a.type == 'qrcode' || a.type == 'text-fx') {

								customdesign.get.el('fill').closest('li[data-tool="fill"]').css({'border-bottom': '3px solid '+this.value});
							    a.set('fill', this.value);

							    if (a._element && a._element.src.indexOf('data:image/svg+xml;base64') > -1){

									var svg = customdesign.fn.fill_svg(a._element.src, this.value);

									a._element.src = svg;
									a._element.onload = function(){
										c.renderAll();
									};
									a.set({'colors': [this.value], origin_src: svg, src: svg});
									return;

							   	}else{

									if (this.value !== '') {

										var tint = new fabric.Image.filters.Tint({
									        color: this.value,
									    });

										if (!a.filters)
											a.filters = [];

										if (a.filters.length == 0)
										    a.filters.push(tint);
									    else{
										    var fil = a.filters.filter(function(f){return (f.color !== undefined);});
										    if (fil.length > 0)
										    	fil[0].color = this.value;
										    else a.filters.push(tint);
									    }

									    if (a.type == 'qrcode')
									  		a.backgroundColor = customdesign.fn.invert(this.value);

								    }else{
									    var fils = [];
									    a.filters.map(function(f){
										    if (f.color === undefined)
										    	fils.push(f);
									    });
									    a.filters = fils;
								    };
								    
									if (typeof a.applyFilters == 'function')
							   			a.applyFilters(c.renderAll.bind(c));

							   	}

							} else if (a.type != 'path-group' && a.type != 'svg') {
								a.set('fill', this.value);
							};

							if (a.type != 'text-fx')
								c.renderAll();
							else customdesign.fn.update_text_fx();

							customdesign.design.layers.build();

						}

					},

					fillStroke : function(e){

						var c = customdesign.stage().canvas,
							a = c.getActiveObject();

						if (a && a.strokeWidth >0/*!e.isTrigger*/) {
							a.set('stroke', this.value);
							c.renderAll();
						}

					},
					
					svgFillColor : function(e) {
						
						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject(),
							c = this.value,
							o = this.getAttribute('data-active-color');
						
						if (active === undefined || active === null)
							return;
						
						if (active.j_object === undefined) {
							$('#customdesign-color-picker-header i').click();
							return;
						};
							
						customdesign.tools.svg.replace(active.j_object, c, o);
						var src = 'data:image/svg+xml;base64,'+btoa(active.j_object.html());
						
						customdesign.get.el('svg-colors').find('span[data-color="'+o+'"] input').css({'background-color': c});
						
						active.set('fill', '');
						active.set('src', src);
						active.set('origin_src', src);
						active._element.src = src;
						active._originalElement.src = src;
						active._element.onload = function(){
							canvas.renderAll();	
						}
							
					},
					
					saveColor : function(e){

						var color = customdesign.get.el(this.getAttribute('data-target')).val().toString().toLowerCase();
						var colors = '#F4511E|#546E7A|#00ACC1|#3949AB|#5E35B1|#e53935|#FDD835|#7CB342|#6D4C41|#8E24AA';

						if (color.indexOf('rgb') === 0)
							color = customdesign.tools.svg.rgb2hex(color);
							
						color = color.toUpperCase();

						if (localStorage.getItem('customdesign_color_presets'))
							colors = localStorage.getItem('customdesign_color_presets');

						colors = colors.split('|');

						if (color === '' || colors.indexOf(color) > -1)
							return;

						colors.unshift(color);
						while(colors.length > 10)
							colors.pop();

						localStorage.setItem('customdesign_color_presets', colors.join('|'));

						customdesign.render.colorPresets();

					},

					enableCurved : function(e){

						if (e.isTrigger)
							return;

						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject(),
							props, text, newobj = null;

						if (!active)
							return;

						if (this.checked && active.type == 'i-text') {

							props = active.toObject(customdesign.ops.export_list);
							delete props['type'];

							props['clipTo'] = function(ctx) {
				            	return customdesign.objects.clipto(ctx, newobj);
							};

							[
								['textAlign', 'center'],
								['radius', 50],
								['spacing', 5],
								['angle', 0],
								['effect', 'bridge']
							].map(function(p){
								if (props[p[0]] === undefined)
									props[p[0]] = p[1];
							});

							newobj = new fabric.CurvedText(active.getText().trim(), props);

						}else if (!this.checked && active.type == 'curvedText'){

							props = active.toObject(customdesign.ops.export_list);
							props['text'] = active.getText().trim();
							delete props['type'];

							props['clipTo'] = function(ctx) {
					            return customdesign.objects.clipto(ctx, newobj);
					        };

							newobj = customdesign.objects.text(props);

						}

						if (newobj !== null) {
							var index = canvas.getObjects().indexOf(active);
							canvas.remove(active);
							customdesign.stage().stack.data.pop();
							canvas.add(newobj);
							newobj.moveTo(index);
							canvas.setActiveObject(newobj).renderAll();
							customdesign.design.layers.build();
						}else{
							alert(customdesign.i(18));
						}

					},

					text_effect: function(e) {

						if (e.isTrigger)
							return;

						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject(),
							effect = this.getAttribute('data-effect'),
							props = active.toObject(customdesign.ops.export_list), text, newobj = null,
							_this = this;

						if (!active)
							return;

						customdesign.f('Processing..');


						$(this.parentNode).find('[data-selected]').attr({'data-selected': ''});
						$(this).attr({'data-selected': 'true'});

						if (effect == 'curved') {

							delete props['type'];

							props['clipTo'] = function(ctx) {
				            	return customdesign.objects.clipto(ctx, newobj);
							};

							[
								['textAlign', 'center'],
								['radius', 50],
								['spacing', 5],
								['angle', 0],
								['effect', 'bridge']
							].map(function(p){
								if (props[p[0]] === undefined)
									props[p[0]] = p[1];
							});

							newobj = new fabric.CurvedText(active.text.trim(), props);

							customdesign.fn.switch_type (newobj);
							newobj.set('radius', 50);
							canvas.renderAll();

						}else{

							props['text'] = active.text.trim();
							delete props['type'];

							props['clipTo'] = function(ctx) {
					            return customdesign.objects.clipto(ctx, newobj);
					        };

							if (effect == 'normal')
								return customdesign.fn.switch_type(customdesign.objects.text(props));

							if (props['bridge'] === undefined) {
								props['bridge'] ={
									curve: -2.5,
									offsetY: 0.5,
									bottom: 2.5,
									trident: false,
									oblique: false,
								}
							}

							props.bridge.oblique = (effect == 'oblique');

							if (effect == 'oblique')
								customdesign.get.el('text-fx-trident').closest('li[data-func="text-fx"]').hide();
							else customdesign.get.el('text-fx-trident').closest('li[data-func="text-fx"]').css({'display': ''});

							if (active.type == 'text-fx') {

								active.set({
									bridge: props.bridge
								});
								
								var dataSrc = customdesign.fn.bridgeText(active.cacheTextImageLarge, active.bridge);
								
								active._element.onload = function(){
									canvas.renderAll();
									customdesign.f(false);
									customdesign.get.el('text-effect').find('img[data-effect]').attr({'data-selected': null});
									customdesign.get.el('text-effect').find('img[data-effect="'+effect+'"]').attr({'data-selected': 'true'});
								};
	
								active._element.src = dataSrc;
								active._originalElement.src = dataSrc;
						
							}else{
								customdesign.objects.customdesign['text-fx'](props, customdesign.fn.switch_type);
							}

						}


					},

					editText : function(e){

						var c = customdesign.stage().canvas,
							a = c.getActiveObject(),
							t = this,
							done = function(){
								c.renderAll();
								customdesign.get.el('workspace').find('.customdesign-edit-text').val(t.value);
							};

						if (a) {

							if (!e.isTrigger) {


								switch (a.type) {
									case 'curvedText' :
										a.setText(this.value);
									break;
									case 'i-text' :
										a.setText(this.value);
									break;
									case 'qrcode':
										var qrcode = customdesign.tools.qrcode({
											text: this.value,
											foreground: a.fill
										});

										a._element.onload = done;

										a._element.src = qrcode.toDataURL();

										a.set({
											'text': this.value,
											'name': a.name ? a.name : this.value,
											'fill': a.fill
										});

										return delete qrcode;

									break;
									case 'text-fx':
										a.set('text', this.value);
									break;
								}

								done();

							}

						}

					},

					textFormat : function(e){

						var c = customdesign.stage().canvas, 
							a = c.getActiveObject(),
							fm = this.getAttribute('data-format'),
							_this = this;
						
						if (a && !e.isTrigger) {

							if (_this.getAttribute('data-align')) {

								$(_this.parentNode).find('[data-align].selected').removeClass('selected');
								$(_this).addClass('selected');
								a.set('textAlign', _this.getAttribute('data-align'));
								customdesign.get.el('text-align').attr({'class': 'customdesignx-align-'+(_this.getAttribute('data-align') ? _this.getAttribute('data-align') : 'center')});

							}else if (fm) {
								
								if (fm == 'upper') {
									if (a.get('text').toString() != a.get('text').toString().toUpperCase())
										a.setText(a.get('text').toString().toUpperCase());
									else a.setText(a.get('text').toString().toLowerCase());
								}else{
									[['bold', 'fontWeight'], ['italic', 'fontStyle'], ['underline', 'textDecoration']].map(
									function(f){
										if (fm == f[0]) {
											if ($(_this).hasClass('selected')) {
												$(_this).removeClass('selected');
												a.set(f[1], '');
											}else{
												$(_this).addClass('selected');
												a.set(f[1], f[0]);
											}
										}
									});
								}

							}

							if (a.type != 'text-fx'){
								document.fonts.load(a.fontStyle+' '+a.fontWeight+' 1px '+a.fontFamily, 'a').then(function(){
									fabric.util.clearFabricFontCache(a.fontFamily);
									c.renderAll();
								});
							}else customdesign.fn.update_text_fx();

						}
					},

					textFX : function(el, e, ratio) {

						if (e !== undefined && e.isTrigger !== undefined)
							return;

						var s = customdesign.get.stage();
						if (!s.active)
							return;

						if (!s.active.bridge)
							s.active.bridge = {};

						var ev = 'input';

						if (el.target) {
							el = this;
							ratio =  parseFloat(this.getAttribute('data-ratio')) || 1;
							ev = 'change';
						}

						var fx = el.getAttribute('data-fx');

						if (fx == 'trident')
							s.active.bridge[fx] = el.checked;
						else s.active.bridge[fx] = parseFloat(el.value)*ratio;

						var dataSrc;

						if (ev == 'change')
							dataSrc = customdesign.fn.bridgeText(s.active.cacheTextImageLarge, s.active.bridge);
						else dataSrc = customdesign.fn.bridgeText(s.active.cacheTextImage, s.active.bridge);

						s.active._element.onload = function(){
							s.active.set('fill', s.active.fill);
							s.canvas.renderAll();
						};

						s.active._element.src = dataSrc;
						s.active._originalElement.src = dataSrc;

					},
					
					strokeColor : function(e) {
						
						var act = customdesign.stage().canvas.getActiveObject(),
							color = this.getAttribute('data-color'),
							stk = customdesign.get.el('stroke').get(0),
							strwidth = customdesign.get.el('stroke-width').val();
							
						if (stk.color && typeof stk.color.fromString == 'function')
							stk.color.fromString(color);
							
						act.set('stroke', this.getAttribute('data-color'));
						customdesign.stage().canvas.renderAll();
						//act.set('stroke-width', strwidth/10);
						
					},
					
					imageFX: function(e) {

						this.setAttribute('data-value', this.value);
						customdesign.fn.update_image_fx(this.getAttribute('data-image-fx'), this.value);

					},

					doArrange : function(e) {

						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject();

						if (!active)
							return;

						var objects = canvas.getObjects(),
							index = objects.indexOf(active);

						if (this.getAttribute('data-arrange') == 'forward')
						{
							if (objects[index+1] !== undefined)
							{

					     	   	active.moveTo(index+1);
					     	   	canvas.renderAll();

								return customdesign.design.layers.build();

							}
							else
								return $(this).addClass('disabled');
						}
						else
							if (this.getAttribute('data-arrange') == 'back')
						{
							if (
								objects[index-1] !== undefined &&
								objects[index-1].evented !== false
							) {

					     	   	active.moveTo(index-1);
						 	   	canvas.renderAll();

								return customdesign.design.layers.build();

							}
							else
								return $(this).addClass('disabled');
						}

					},

					load_fonts : function() {

						customdesign.tools.lightbox({
							width: 1020,
							content: '<iframe src="https://services.customdesign.com/fonts/"></iframe>\
									  <span data-view="loading"><i class="customdesign-spinner x3"></i></span>'
						});
						
						$('#customdesign-lightbox iframe').on('load', function() {
							this.contentWindow.postMessage({
								action: 'fonts',
								fonts: localStorage.getItem('CUSTOMDESIGN_FONTS')
							}, "*");
							$('#customdesign-lightbox span[data-view="loading"]').remove();
						});

					},

					select_font : function(e) {

						var family = e.target.getAttribute('data-family');

						if (family) {

							customdesign.get.el('fonts').find('font.selected').removeClass('selected');
							
							$(e.target).addClass('selected').
								closest('li[data-tool="font"]').
								find('button.dropdown').html('<font style="font-family:\''+family+'\'">'+family+'</font>');

							var canvas = customdesign.stage().canvas,
								active = canvas.getActiveObject();

							if (active.fontFamily == family)
								return;

							active.set('fontFamily', '"'+family+'"');

							if (e.target.getAttribute('data-source')) {
								active.set('font', e.target.getAttribute('data-source'));
								customdesign.fn.font_blob(active);
							}else{
								fonts = JSON.parse(localStorage.getItem('CUSTOMDESIGN_FONTS'));
								if (fonts[encodeURIComponent(family)])
									active.set({font: fonts[encodeURIComponent(family)]});
							}
							
							if (active.type != 'text-fx')
								canvas.renderAll();
							else customdesign.fn.update_text_fx();
						}

					},

					flip : function(e) {

						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject();

						if (this.id == 'customdesign-flip-x')
							active.set('flipX', this.checked);
						else active.set('flipY', this.checked);

						canvas.renderAll();

					},
					
					lock_position : function(e) {
						
						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject();

						active.set({
							'lockPosition': this.checked,
							'lockMovementX': this.checked,
							'lockMovementY': this.checked
						});
						
						customdesign.get.el('position-wrp').attr({'data-lock': this.checked === true ? 'true' : 'false'});
						
						canvas.renderAll();
							
					},
					
					resetTransform: function() {

						var canvas = customdesign.stage().canvas,
							active = canvas.getActiveObject();

						active.set({
							scaleY: active.scaleX,
							skewX: 0,
							skewY: 0,
							angle: 0,
							flipX: false,
							flipY: false
						});

						canvas.renderAll();
						customdesign.tools.set(active);

					},

					selectImageFX: function(e) {

						customdesign.fn.update_image_fx(this.getAttribute('data-fx'), this.value);

					},

					imageColorFX: function(e) {

						var s = customdesign.get.stage();

						if (this.getAttribute('data-fx') == 'bnw') {
							return $('#customdesign-image-fx-saturation').val(0).trigger('change');
						}else if (s.active.fx && s.active.fx.saturation == 0) {
							s.active.fx.saturation = 100;
							$('#customdesign-image-fx-saturation').val(100).trigger('input');
						}else if (this.getAttribute('data-fx') === '') {
							s.active.fx.saturation = 100;
							s.active.fx.brightness = 0;
							s.active.fx.contrast = 0;
							customdesign.get.el('image-fx-brightness').val(0).attr({'data-value': 0});
							customdesign.get.el('image-fx-contrast').val(0).attr({'data-value': 0});
							customdesign.get.el('image-fx-saturation').val(100).attr({'data-value': 100});
						}

						$(this.parentNode).find('[data-selected="true"]').removeAttr('data-selected');
						$(this).attr({'data-selected': 'true'});
						
						customdesign.fn.update_image_fx('fx', this.getAttribute('data-fx'));

					},
					
					bug_submit: function(e) {
						
						var wrp = customdesign.get.el('bug'),
							content = wrp.find('textarea[data-id="report-content"]').val();
						
						if (content.length < 30)
							return wrp.find('textarea[data-id="report-content"]').shake();
						
						content = btoa(encodeURIComponent(content.substr(0, 1500)));
						
						wrp.attr({'data-view': 'sending'});
						customdesign.post({
							action: 'send_bug',
							content: content
						}, function(res) {
							try {
								res = JSON.parse(res);
							}catch(ex) {
								res = {};	
							};
							if (res.success != 1) {
								wrp.removeAttr('data-view');
								customdesign.fn.notice(res.message, 'error', 3500);
								return;
							};
							wrp.attr({'data-view': 'success'});
							setTimeout(function(){
								wrp.removeAttr('data-view');
								wrp.find('textarea[data-id="report-content"]').val('');
							}, 10000);
						});
						
					},
					
					options: function() {
						if (typeof this.getAttribute == 'function')
							localStorage.setItem('CUSTOMDESIGN-'+this.getAttribute('data-name'), this.checked);
					},

					exit_drawing : function(){
						customdesign.get.el('left .customdesign-left-nav li[data-tab="layers"]').trigger('click');
					},

					saved_designs : function(e) {
						
						let act, id, el;
						
						el = e.target.getAttribute('data-func') ? $(e.target) : $(e.target).closest('[data-func]');
						
						act = e.target.getAttribute('data-func') ? 
							  e.target.getAttribute('data-func') : 
							  $(e.target).closest('[data-func]').attr('data-func');
						
						id = e.target.getAttribute('data-id') ? 
							 e.target.getAttribute('data-id') : 
							 $(e.target).closest('[data-id]').attr('data-id');
						
						if (!act)
							return;
						
						customdesign.ops.preventClick = true;
							
						if (!id && act != 'new')
							return;
						
						let is_save = ($('#customdesign-saved-designs').attr('is') == 'save');
						
						switch (act) {

							case 'edit' :
							
								if (id == 'new' || is_save) {
									
									let is_empty_design = true;
									
									Object.keys(customdesign.cart.printing.states_data).map(function(s) {
									    Object.keys(customdesign.cart.printing.states_data[s]).map(function(d) {
									        if (
									        	typeof customdesign.cart.printing.states_data[s][d] == 'number' && 
									        	customdesign.cart.printing.states_data[s][d] !== 0
									        )
									            is_empty_design = false;
									    });
									});
									
									if (is_empty_design)
										return customdesign.fn.notice(customdesign.i(96), 'error', 3500);
									
									if (is_save)
										customdesign.fn.export('designs', id, el.attr('data-created'), el.attr('data-name'));
									else customdesign.fn.export('designs');
									
									$('#customdesign-navigations').attr({'data-navigation': ''});
									$('li[data-tool]').removeClass('active');
									return customdesign.fn.notice(customdesign.i(109), 'success', 3500);;
									
								};
								
								customdesign.indexed.get(id, 'dumb', function(res){
									if (res !== null) {
										customdesign.fn.set_url('cart', null);
										customdesign.ops.my_designs[id].stages = res.stages;
										customdesign.fn.edit_design(customdesign.ops.my_designs[id]);
									} else {
										customdesign.fn.notice(customdesign.i(166), 'error', 3500);
									}
								});

							break;

							case 'name' :
								var name = $(e.target).text();
								e.target.onblur = function(){
									if (name != $(this).text()) {
										name = $(this).text();
										$(e.target).closest('li[data-name]').attr({'data-name': name});
										setTimeout(function(){
											customdesign.indexed.get(id, 'designs', function(res){
												if (res !== null) {
													res.name = name;
													customdesign.indexed.get(id, 'dumb', function(res_dumb){
														if (res_dumb !== null) {
															res_dumb.name = name;
															customdesign.indexed.save([res, res_dumb], 'designs');
															delete res;
															delete res_dumb;
														}
													});
												}
											});
										}, 300);
									}
								};
								$(e.target).off('keydown').on('keydown', function(e) {
									if (e.keyCode === 13) {
										e.preventDefault();
										this.blur();
									}
								});
							break;

							case 'delete' :
								
								if (!confirm(customdesign.i('sure')))
									return;

								customdesign.indexed.delete(id, 'designs');

								$(e.target).closest('li[data-id]').find('img').each(function(){
									if (this.src.indexOf('blob:') === 0)
										URL.revokeObjectURL(this.src);
								});
								
								$(e.target).closest('li[data-id]').remove();

							break;
						}

					},
					
					saved_designs_search : function(e) {
						
						var val = this.value.trim().toLowerCase();
						
						customdesign.get.el('saved-designs').find('li').each(function(){
							if (val === '' || $(this).find('span[data-view="name"]').text().trim().toLowerCase().indexOf(val) > -1)
								this.style.display = '';
							else this.style.display = 'none';
						});
					},
					
					change_lang : function(e) {
						
						customdesign.post({
							action: 'change_lang',
							code: this.getAttribute('data-id')
						});
						customdesign.fn.set_url('lang',this.getAttribute('data-id'));
						$(this).closest('li[data-tool="languages"]').
								removeClass('active').
								html('<i class="customdesign-spinner white"></i>');
					},

					change_product : function(e) {
						
						var btn_txt = customdesign.fn.url_var('product_base') ? customdesign.i(80) : customdesign.i(87);
						
						customdesign.render.products_list(btn_txt);
						
					},

					fileNav : function(e) {

						var func = this.getAttribute('data-func');

						switch (func) {
							
							case 'new' : customdesign.design.my_designs['new'](); break;

							case 'import' :

								var inp = customdesign.get.el('import-json').get(0);
								
								inp.type = '';
								inp.type = 'file';
								inp.click();

								if (customdesign.get.el('import-json').data('addEvent') !== true) {

									customdesign.get.el('import-json').data({'addEvent': true}).on('change', function(){
										
										customdesign.design.my_designs['import'](this.files[0]); 
										
									});
								}
								
							break;
							case 'clear' :
								customdesign.tools.clearAll();
								customdesign.fn.notice(customdesign.i(29), 'success');
							break;
							case 'saveas' :
								customdesign.fn.download_design({type: 'json'});
							break;
							case 'save' :
								customdesign.fn.notice(customdesign.i(109), 'success');								
								customdesign.fn.export('designs');
								
							break;
							case 'download' :

								customdesign.fn.download_design({type: this.getAttribute('data-type')});
								
							break;
						}

						customdesign.fn.navigation('clear');

					},

					doPrint : function(e) {
						
						var pcfg = localStorage.getItem('CUSTOMDESIGN_PRINT_CFG'),
							format = this.getAttribute('data-format');
						
						if (!pcfg || pcfg === '')
							pcfg = {};
						else pcfg = JSON.parse(pcfg);
						
						switch (this.getAttribute('data-dp')) {
							
							case 'format': 
							
								var inps = ['li[data-row="size"]', 
										'li[data-row="csize"]', 
										'li[data-row="unit"]', 
										'li[data-row="orien"]',
										'button[data-func="print"]'],
									stage = customdesign.stage(),
									size = (stage !== undefined && stage.size !== undefined ? stage.size : '');
								
								inps = $('#customdesign-print-nav').find(inps.join(','));
								
								pcfg.format = format;
								
								if (format == 'png') {
									if (size !== '') {
										inps.hide();
										if ($('#customdesign-print-nav li[data-row="size"] select option[value="'+size+'"]').length > 0) {
											$('#customdesign-print-nav').find('li[data-row="size"]').show();
										} else {
											$('#customdesign-print-nav').find('li[data-row="csize"],li[data-row="unit"]').show();
										}
									} else inps.show();
									$('#customdesign-print-nav customdesign-btn[data-func="print"]').show();
								} else { 
									inps.hide();
									$('#customdesign-print-nav customdesign-btn[data-func="print"]').hide();
									$('#customdesign-print-nav').find('li[data-row="size"]').hide();
								}
									
								if (format == 'pdf')
									$('#customdesign-print-nav').find('li[data-row="full"], li[data-row="cropmarks"]').show();
								else $('#customdesign-print-nav').find('li[data-row="full"], li[data-row="cropmarks"]').hide();
								
							break;
							
							case 'csize' : 
								pcfg.csize = this.value; 
							break;
							case 'orien' : 
								pcfg.orien = this.value; 
							break;
							case 'base' : 
								pcfg.base = this.checked; 
							break;
							case 'overflow' : 
								pcfg.overflow = this.checked; 
							break;
							case 'cropmarks' : 
								pcfg.cropmarks = this.checked; 
							break;
							case 'all_pages' : 
								pcfg.all_pages = this.checked; 
							break;
							
							case 'unit':
							
								var val = $('#customdesign-print-nav select[name="select-size"]').val();
								inp = $('#customdesign-print-nav input[name="size"]'),
								unit = this.getAttribute('data-unit');
								
								if (val === '' || val === null)
									return;
									
								pcfg.unit = unit;
								
								val = val.split('x');
								
								val[0] = parseFloat(val[0].trim());
								val[1] = parseFloat(val[1].trim());
								
								if (unit == 'inch') {
									val[0] = (val[0]/2.54).toFixed(2);
									val[1] = (val[1]/2.54).toFixed(2);
								} else if (unit == 'px') {
									val[0] = (val[0]*118.095238).toFixed(2);
									val[1] = (val[1]*118.095238).toFixed(2);
								}
								
								val = val.join(' x ');
								
								inp.val(val);
								
								pcfg.csize = val;
								
							break;
							
							case 'size':
								
								var unit = $('#customdesign-print-nav input[name="print-unit"]:checked').data('unit'),
								val = this.value;
								
								if (val === '')
									return;
									
								pcfg.size = val;
								
								val = val.split('x');
								val[0] = parseFloat(val[0].trim());
								val[1] = parseFloat(val[1].trim());
								
								if (unit == 'inch') {
									val[0] = (val[0]/2.54).toFixed(2);
									val[1] = (val[1]/2.54).toFixed(2);
								} else if (unit == 'px') {
									val[0] = (val[0]*118.1).toFixed(0);
									val[1] = (val[1]*118.1).toFixed(0);
								}
								
								val = val.join(' x ');	
								
								pcfg.csize = val;
								
								customdesign.get.el('print-nav').find('input[name="size"]').val(val);
							
							break;
						};
						
						if (this.tagName == 'BUTTON') {
							
							var format = $('#customdesign-print-nav input[name="print-format"]:checked').attr('data-format'),
								include_base = $('#customdesign-print-base').prop('checked'),
								full = $('#customdesign-print-full').prop('checked'),
								overflow = $('#customdesign-print-overflow').prop('checked'),
								stage = customdesign.stage(),
								func = this.getAttribute('data-func');
							
							if (format == 'svg' || format == 'pdf')
								return customdesign.fn.download_design({type: format, include_base: include_base, full: full});
							
							document.getElementById('CustomdesignDesign').setAttribute('data-processing', 'true');
							document.getElementById('CustomdesignDesign').setAttribute('data-msg', customdesign.i('render'));
							
							customdesign.get.el('zoom').val('100').trigger('input');
							
							var psize = customdesign.get.size();
							
							customdesign.fn.uncache_large_images(function() {
								
								customdesign.f(false);
										
								customdesign.fn.download_design({
									type: 'png',
									orien: psize.o,
									height: psize.h,
									width: psize.w,
									include_base: include_base,
									callback: function(data) {
										
										/*
										*	 Revert cache of large images
										*/
										
										customdesign.fn.uncache_large_images(null, true);
										
										if ( func == 'download' ) {
											
											name = customdesign.data.prefix_file+'_print_'+customdesign.current_stage+'.png';
											
											if (customdesign.fn.url_var('order_print', '') !== '') {
												name = 'order-'+customdesign.fn.url_var('order_print')
														+'__product-'+customdesign.fn.url_var('product_cms')
														+'__base-'+customdesign.fn.url_var('product_base')+'__stage-'
														+(Object.keys(customdesign.data.stages).indexOf(customdesign.current_stage)+1)+'.png';
											};
											
											customdesign.fn.download(data, name);
											customdesign.f(false);
											return;
											
										};
			
										if (data.length < 10)
											return alert(customdesign.i(36));
			
										var print_window = window.open();
										print_window.document.write(
											'<img style="width:100%" src="'+data+'" onload="window.print();window.close();" />'
										);
										
									}	
								});
								
							});

						};
						
						localStorage.setItem('CUSTOMDESIGN_PRINT_CFG', JSON.stringify(pcfg));
						
					},
					
					nav : function(e) {
						
						if (e.target.getAttribute('data-func') == 'nav') {
							
							var el = $(e.target),
								nav = el.data('nav'),
								wrp = el.closest('.customdesign-tabs-nav').find('li[data-view="'+nav+'"]');
							
							el.closest('.customdesign-tabs-nav').attr({'data-nav': nav}).find('[data-active="true"]').removeAttr('data-active');
							el.attr({'data-active': 'true'});
							wrp.attr({'data-active': 'true'});
							
							e.preventDefault();
						}
					},
					
					doShare : function(e) {
						
						var func = e.target.getAttribute('data-func');
						
						if (!func)
							return;
							
						var share_history = localStorage.getItem('CUSTOMDESIGN_SHARE_HISTORY'),
							el = $(e.target);
								
						if (!share_history) {
							share_history = [];
						} else {
							try {
								share_history = JSON.parse(share_history);
							}catch(ex){
								share_history = [];
							}
						};
						
						if (share_history.length > 3)
							share_history.splice(3);
						
						var load_history = function(index) {
										
							var wrp = customdesign.get.el('shares-wrp').find('li[data-view="history"]');
							wrp.attr({'data-process': 'true'});
							
							customdesign.post({
								action: 'get_shares',
								index: index,
								stream: customdesign.fn.url_var('stream', '')
							}, function(res){
								
								wrp.removeAttr('data-process');
								
								var res = JSON.parse(res);
									
								if (res.result.length > 0) {
									
									var html = '', share_url = '';
									res.result.map(function(s){
										
										share_url = customdesign.data.tool_url;
										
										if (share_url.indexOf('?') > -1)
											share_url += '&';
										else share_url += '?';
										
										share_url += 'product_base='+s.product;
										share_url += '&product_cms='+s.product_cms;
										share_url += '&share='+s.share_id;
										
										share_url = share_url.replace('?&', '?');
										
										html += '<span data-item>\
											<a href="'+share_url+'" target="_blank">\
												<img src="'+customdesign.data.upload_url+'shares/'+customdesign.fn.date('Y/t', s.created)+'/'+s.share_id+'.jpg'+'" height="150" />\
											</a>\
											<name>'+s.name+'</name>\
											<span data-view="func">\
												<i class="customdesign-icon-menu"></i>\
												<span data-view="fsub" data-id="'+s.share_id+'" data-aid="'+s.aid+'" data-link="'+ encodeURIComponent(share_url)+'" data-created="'+s.created+'">\
													<date data-func="date">'+customdesign.fn.date('h:m D d M, Y', s.created)+'</date>\
													<button data-func="copy-link">\
														<i class="customdesign-icon-doc"></i> '+customdesign.i(130)+'\
													</button>\
													<button data-func="open">\
														<i class="customdesign-icon-link"></i> '+customdesign.i(131)+'\
													</button>\
													<button data-func="delete">\
														<i class="customdesign-icon-trash"></i> '+customdesign.i(132)+'\
													</button>\
												</span>\
											</span>\
										</span>';
									});
									
									wrp.html(html);
									
								} else {
									wrp.html('<p class="notice mt2 mb2">'+customdesign.i(129)+'</p>');
								};
								
								if (res.per_page < res.total) {
									
									var nav = '<ul data-view="pagenation">';
									
									if (res.index > res.per_page) {
										nav += '<li data-func="pagination" data-p="0"><i data-func="pagination" data-p="0" class="customdesignx-ios-arrow-back"></i><i data-func="pagination" data-p="0" class="customdesignx-ios-arrow-back"></i></li>';
									};
									
									for (var i=1; i<=Math.ceil(res.total/res.per_page); i++) {
										nav += '<li data-func="pagination" data-p="'+((i-1)*res.per_page)+'"'+(res.index == i*res.per_page ? ' data-active="true"' : '')+'>'+i+'</li>';
									};
									
									if (res.index < res.total) {
										nav += '<li data-func="pagination" data-p="'+((Math.ceil(res.total/res.per_page)-1)*res.per_page)+'"><i data-func="pagination" data-p="'+((Math.ceil(res.total/res.per_page)-1)*res.per_page)+'" class="customdesignx-ios-arrow-forward"></i><i data-func="pagination" data-p="'+((Math.ceil(res.total/res.per_page)-1)*res.per_page)+'" class="customdesignx-ios-arrow-forward"></i></li>';
									};
									nav += '</ul>';
									
									wrp.append(nav);
									
								} else if (res.index > res.per_page && res.result.length > 0){
									wrp.append('<p class="center">'+customdesign.i(134)+'</p>');
								}
								
							});
						};
						
						if (el.data('nav') == 'history')
							load_history(0);
						
						switch (func) {
							
							case 'nav' : 
								return e.data.nav(e);
							break;
							
							case 'pagination' : 
								load_history(el.data('p'));
							break;
							
							case 'copy-link' : 
								customdesign.fn.copy(decodeURIComponent(el.closest('[data-view="fsub"]').data('link')));
								customdesign.fn.notice(customdesign.i(135), 'success');
							break;
							
							case 'open' : 
								window.open(decodeURIComponent(el.closest('[data-view="fsub"]').data('link')));
							break;
							
							case 'delete' : 
								customdesign.fn.confirm({
									title: customdesign.i(133),
									primary: {
										text: 'Delete',
										callback: function(e) {
											el.closest('span[data-item]').css({opacity: 0.25});
											customdesign.post({
												action: 'delete_link_share',
												aid: el.closest('[data-view="fsub"]').data('aid'),
												id: el.closest('[data-view="fsub"]').data('id')
											}, function(res){
												res = JSON.parse(res);
												if (res.success == 0) {
													el.closest('span[data-item]').css({opacity: 1});
													customdesign.fn.notice(res.message, 'error');
												} else el.closest('span[data-item]').remove();
											});
									
										}
									},
									second: {
										text: 'Cancel'
									}
								});
							break;
							
							case 'create-link' :
								
								var restrict = false;
								
								if (
									share_history.length == 3 && 
									new Date().getTime() - (parseInt(share_history[0]*1000)) < 5*60*1000 
								) {
									restrict = true;
								};
								
								if (restrict === true) {
									
									customdesign.fn.confirm({
										title: customdesign.i(128),
										primary: {},
										second: {
											text: 'Ok'
										},
										type: 'notice'
									});
									
									return;
								};
								
								if ($('#customdesign-share-link-title').val() === '') {
									$('#customdesign-share-link-title').shake();
									e.preventDefault();
									return;
								};
								
								var has_design = 0;
								
								Object.keys(customdesign.data.stages).map(function(s) {
									if (
										typeof customdesign.data.stages[s] !== 'undefined' && 
										typeof customdesign.data.stages[s].canvas !== 'undefined'
									){
										var canvas = customdesign.data.stages[s].canvas,
											objs = canvas.getObjects();
										
										if (objs.filter(function(o) {return o.evented === true;}).length > 0) {
											has_design++;
										}
										
									};
								});
								
								if (
									has_design === 0
								) {
									customdesign.fn.notice(customdesign.i(96), 'error');
									delete cart_data;
									delete cart_design;
									return false;
								};
								
								if (
									customdesign.data.required_full_design == '1' &&
									has_design < Object.keys(customdesign.data.stages).length
								) {
									customdesign.fn.notice(customdesign.i(210), 'error');
									delete cart_data;
									delete cart_design;
									return false;
								};
								
								var wrp = $(e.target).closest('#customdesign-shares-wrp'),
									data = customdesign.fn.export('share'),
									screenshot = data.stages[Object.keys(data.stages)[0]].screenshot;
								
								Object.keys(data.stages).map(function(s){
									data.stages[s].screenshot = '';
								});
								
								let items = [],
									formData = new FormData(),
									blob = '',
									upload_size = 100;
								
								formData.append('action', 'upload_share_design'); 
								formData.append('ajax', 'frontend'); 
								formData.append('nonce', 'CUSTOMDESIGN-SECURITY:'+customdesign.data.nonce); 
								formData.append('aid', customdesign.fn.get_cookie('customdesign-AID')); 
								formData.append('label', $('#customdesign-share-link-title').val()); 
								formData.append('product_cms', customdesign.fn.url_var('product_cms', '')); 
								formData.append('product', customdesign.fn.url_var('product_base', '')); 
								
								blob = JSON.stringify(data);
								formData.append('data', new Blob([blob]));
								formData.append('screenshot', new Blob([screenshot]));
								
								upload_size += blob.length+screenshot.length;
								
					            
					            if (customdesign.data.max_upload_size > 0 && upload_size/1024000 > customdesign.data.max_upload_size) {
						            customdesign.fn.notice('Error: your design is too large ('+(upload_size/1024000).toFixed(2)+'MB out of max '+customdesign.data.max_upload_size +'MB)<br>Please contact the administrator to change the server configuration', 'error', 5000);
						            return customdesign.f(false);
					            }
					            
					            customdesign.f('0% complete');
									
								 $.ajax({
								    data	:	 formData,
								    type	:	 "POST",
								    url		:	 customdesign.data.ajax,
								    contentType: false,
								    processData: false,
								    xhr		:	 function() {
									    var xhr = new window.XMLHttpRequest();
									    xhr.upload.addEventListener("progress", function(evt){
										    
										    if (evt.lengthComputable) {
										        var percentComplete = evt.loaded / evt.total;
										        if (percentComplete < 1)
										       		$('div#CustomdesignDesign').attr({'data-msg': parseInt(percentComplete*100)+'% upload complete'});
										        else $('div#CustomdesignDesign').attr({'data-msg': customdesign.i(159)});
										    }
										    
									    }, false);
									    return xhr;
									},
								    success: function (res, status) {
									    
									    customdesign.f(false);
									     
									    res = JSON.parse(res);
									
										wrp.removeAttr('data-process').find('.customdesign-notice').remove();
										
										if (res.success === 0) {
											wrp.find('li[data-view="link"]').prepend(
												'<p class="notice error mb1" data-phase="1">'+res.message+'</p>'
											);
										} else { 
											
											wrp.attr({'data-phase': '2'});
											
											var share_url = customdesign.data.tool_url;
											
											if (share_url.indexOf('?') > -1)
												share_url += '&';
											else share_url += '?';
											
											share_url += 'product_base='+res.product;
											if (res.product_cms !== null && res.product_cms !== '')
												share_url += '&product_cms='+res.product_cms;
											share_url += '&share='+res.id;
											
											share_url = share_url.replace('?&', '?');
											
											wrp.find('p[data-view="link-share"]').html(share_url);
											
											wrp.find('button[data-network]').off('click').on('click', function(e){
												var nw = this.getAttribute('data-network'),
													link = '';
												if (nw == 'facebook') {
													link = 'https://www.facebook.com/dialog/share?href='+encodeURIComponent(share_url)+'&display=popup&app_id='+customdesign.apply_filters('fbappid', '1430309103691863');
												} else if (nw == 'twitter') {
													link = 'https://twitter.com/intent/tweet?url='+encodeURIComponent(share_url)+'&text='+encodeURIComponent(res.name)+'&via=Customdesign&related=Customdesign,CustomdesignCom,CustomdesignProductDesigner'
												} else if (nw == 'pinterest') {
													link = 'https://www.pinterest.com/pin/create/button/?url='+encodeURIComponent(share_url)+'&description='+encodeURIComponent(res.name)+'&is_video=false&media='+encodeURIComponent(customdesign.data.upload_url+'shares/'+res.path+'/'+res.id+'.jpg')
												}
												
												if (link !== '')
													window.open(link);
												
												e.preventDefault();
											});
											
											share_history.push(res.created);
											
											localStorage.setItem('CUSTOMDESIGN_SHARE_HISTORY', JSON.stringify(share_history));
											
										}
										
								    },
								    error: function() {
									    alert('Error: could not checkout this time');
								    }
								});
								
								wrp.attr({'data-process': 'Creating...'});

							break;
							
							case 'do-again' : 
								customdesign.get.el('shares-wrp').removeAttr('data-phase');
							break;
							
							case 'copy' : 
								
								var el = e.target;
								
								customdesign.fn.copy(el.innerHTML.trim());
								
								el.setAttribute("data-copied", "true");
								setTimeout(function(){
									el.removeAttribute("data-copied");
								}, 1500);
							        
							break;
						}
					},

					my_cart : function(e) {

						var func = e.target.getAttribute('data-func'),
							current = customdesign.fn.url_var('cart', ''),
							id = e.target.getAttribute('data-id');

						if (!func || func === '')
							return;

						switch (func) {
							case 'remove':
								if (confirm(customdesign.i('sure'))) {
									if (current == id)
										customdesign.fn.set_url('cart', null);
									var items = JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA'));
									delete items[id];
									localStorage.setItem('CUSTOMDESIGN-CART-DATA', JSON.stringify(items));
									setTimeout(customdesign.render.cart_change, 150);
								}
							break;
							case 'edit':
								customdesign.cart.edit_item(id, e);
							break;
							case 'checkout':
								customdesign.cart.do_checkout();
							break;
						}

						e.preventDefault();

					}

				});
				
				$('#customdesign-left #customdesign-text *[draggable="true"]').each(function(){
					customdesign.design.event_add_text(this);
				});
				
				var aa = localStorage.getItem('CUSTOMDESIGN-AUTO-ALIGNMENT'),
					ta = localStorage.getItem('CUSTOMDESIGN-TEMPLATE-APPEND'),
					ri = localStorage.getItem('CUSTOMDESIGN-REPLACE-IMAGE'),
					a_a = $('#customdesign-auto-alignment'),
					t_a = $('#customdesign-template-append'),
					r_i = $('#customdesign-replace-image');
				
				if (aa === null)
					localStorage.setItem('CUSTOMDESIGN-AUTO-ALIGNMENT', a_a.prop('checked'));
				else 
					a_a.prop({checked: aa == 'true' ? true : false});
				
				if (ta === null)
					localStorage.setItem('CUSTOMDESIGN-TEMPLATE-APPEND', t_a.prop('checked'));
				else 
					t_a.prop({checked: ta == 'true' ? true : false});
				
				if (ri === null)
					localStorage.setItem('CUSTOMDESIGN-REPLACE-IMAGE', r_i.prop('checked'));
				else 
					r_i.prop({checked: ri == 'true' ? true : false});

				$(document).on('click', function(e){

					if (e.isTrigger !== undefined)
						return;
						
					var except = customdesign.apply_filters('click_except', '');
					
					if (
						!$(e.target).is(except) &&
						$(e.target).closest('#customdesign-stage-nav').length === 0 && 
						customdesign.get.el('stage-nav').hasClass('stages-expand')
					)customdesign.get.el('stage-nav').removeClass('stages-expand').removeClass('preview-designs');
					
					var el = $(e.target);
					
					if (e.target.tagName != 'INPUT' && el.closest('div.customdesign_color_picker').length === 0)
						$('#customdesign-color-picker-header i').click();
						
					if (el.hasClass('close') || el.closest('div#customdesign-x-thumbn-preview,[data-prevent-click="true"]').length === 0) {
						customdesign.get.el('x-thumbn-preview').hide();
					}else if (
						!customdesign.ops.preventClick &&
						!el.hasClass('upper-canvas') &&
						!el.hasClass('close') &&
						customdesign.ops.preventClick !== true &&
						el.closest(
							'div.customdesign-stage.canvas-wrapper,'+
							'[data-view="sub"],'+
							'div.customdesign_color_picker,'+
							'div.customdesign-lightbox,'+
							'ul.customdesign-top-nav,'+
							'[data-prevent-click="true"],'+
							'#customdesign-navigations'
						).length === 0
					){
						if (customdesign.e.main.find('li[data-tool].active').length > 0)
							customdesign.fn.navigation('clear');
						else customdesign.tools.discard();
					};
					
					delete customdesign.ops.preventClick;
					
					$('iframe').each(function(){
						this.contentWindow.postMessage({
							action : 'parentClick'
						}, "*");
					});

				})		   
				.on('keydown', function(e) {

					if (['TEXTAREA', 'INPUT'].indexOf(e.target.tagName) > -1 || e.target.getAttribute('contenteditable'))
						return true;

					if ([37, 38, 39, 40].indexOf(e.keyCode) > -1)
						return customdesign.actions.do('key-move', e);

					if (e.keyCode === 13)
						return customdesign.actions.do('key-enter', e);

					if (e.metaKey === true || e.ctrlKey === true) {
						
						if (e.keyCode === 90) {
							if (e.shiftKey === false)
								return customdesign.actions.do('ctrl-z');
							else return customdesign.actions.do('ctrl-shift-z');
						}else if (e.keyCode === 83) {
							if (e.shiftKey === true)
								return customdesign.actions.do('ctrl-shift-s', e);
							else return customdesign.actions.do('ctrl-s', e);
						}else if (e.keyCode === 80)
							return customdesign.actions.do('ctrl-p', e);
						else if (e.keyCode === 79)
							return customdesign.actions.do('ctrl-o', e);
						else if (e.keyCode === 69)
							return customdesign.actions.do('ctrl-e', e);

					};

					if (e.keyCode === 27)
						return customdesign.actions.do('key-esc');

					switch (e.keyCode) {
						case 8: return customdesign.actions.do('key-delete', e); break;
						case 46: return customdesign.actions.do('key-delete', e); break;
						case 13: return customdesign.actions.do('key-enter', e); break;
						case 27: return customdesign.actions.do('key-esc', e); break;
						case 37:
						case 38:
						case 39:
						case 40: return customdesign.actions.do('key-move', e); break;

					};

					if (e.metaKey === true || e.ctrlKey === true) {
						
						switch (e.keyCode) {
							case 48: return customdesign.actions.do('ctrl-0', e); break;
							case 65: return customdesign.actions.do('ctrl-a', e); break;
							case 68: return customdesign.actions.do('ctrl-d', e); break;
							case 69: return customdesign.actions.do('ctrl-e', e); break;
							case 79: return customdesign.actions.do('ctrl-o', e); break;
							case 80: return customdesign.actions.do('ctrl-p', e); break;
							case 83:
								if (e.shiftKey === true)
									return customdesign.actions.do('ctrl-shift-s', e);
								else return customdesign.actions.do('ctrl-s', e);
							break;
							case 90:
								if (e.shiftKey === false)
									return customdesign.actions.do('ctrl-z');
								else return customdesign.actions.do('ctrl-shift-z');
							break;
							case 61: return customdesign.actions.do('ctrl+', e); break;
							case 173: return customdesign.actions.do('ctrl-', e); break;
							case 107: return customdesign.actions.do('ctrl+', e); break;
							case 109: return customdesign.actions.do('ctrl-', e); break;
							case 187: return customdesign.actions.do('ctrl+', e); break;
							case 189: return customdesign.actions.do('ctrl-', e); break;
						}

					}

				})
				.on('mouseup', function(e){
					customdesign.actions.do('globalMouseUp', e);
				});

				$('#customdesign-upload-form').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
					e.preventDefault();
					e.stopPropagation();
				})
				.on('dragover dragenter', function() {
					$(this).addClass('is-dragover');
				})
				.on('dragleave dragend drop', function() {
					$(this).removeClass('is-dragover');
				})
				.on('drop', function(e) {
					customdesign.fn.process_files(e.originalEvent.dataTransfer.files);
				})
				.on('click', function(){
					$(this).find('input[type="file"]').get(0).click();
				});
				
				var pcfg = localStorage.getItem('CUSTOMDESIGN_PRINT_CFG');
				
				if (pcfg && pcfg !== '') {
					pcfg = JSON.parse(pcfg);
					if (pcfg.format !== undefined)
						$('#customdesign-print-nav input[data-format="'+pcfg.format+'"]').prop({checked: true}).change();
					if (pcfg.unit !== undefined)
						$('#customdesign-print-nav input[data-unit="'+pcfg.unit+'"]').prop({checked: true}).change();
					if (pcfg.size !== undefined)
						$('#customdesign-print-nav select[name="select-size"]').val(pcfg.size).change();
					if (pcfg.csize !== undefined)
						$('#customdesign-print-nav input[name="size"]').val(pcfg.csize).change();
					if (pcfg.orien !== undefined)
						$('#customdesign-print-nav select[name="orientation"]').val(pcfg.orien).change();
					if (pcfg.base !== undefined)
						$('#customdesign-print-nav input[data-dp="base"]').prop({checked: pcfg.base});
					if (pcfg.overflow === undefined || pcfg.overflow == true)
						$('#customdesign-print-nav input[data-dp="overflow"]').prop({checked: true});
					if (pcfg.cropmarks !== undefined)
						$('#customdesign-print-nav input[data-dp="cropmarks"]').prop({checked: pcfg.cropmarks});
					if (pcfg.all_pages !== undefined)
						$('#customdesign-print-nav input[data-dp="all_pages"]').prop({checked: pcfg.all_pages});
				};
				
				customdesign.cliparts.add_events();
				
			},

			event_add_text : function(el) {

				[['dragstart', function(e){

					customdesign.ops.drag_start = this;

					var offs = $(this).offset();

					customdesign.ops.drag_start.distance = {
						x : (e.pageX - offs.left) - (this.offsetWidth/2),
						y : (e.pageY - offs.top) - (this.offsetHeight/2),
						w : this.offsetWidth,
						h : this.offsetHeight
					};

				}],
				['dragend', function(e){

					customdesign.ops.drag_start = null;

				}],
				['click', function(e){

					customdesign.itemInStage('add');
					
					var ops = JSON.parse(this.getAttribute('data-ops'));
					
					if (window.is_first_text === undefined) {
						window.is_first_text = true;
						$('#customdesign-text-tools li[data-tool="spacing"]').trigger('click');
					}
					
					if (this.getAttribute('data-act')) {
						customdesign.fn.preset_import(ops, {}, function() {
							if (ops[0].type == 'text-fx')
								customdesign.fn.update_text_fx();
						});
					}

				}]].map(function(ev){
					el.addEventListener(ev[0], ev[1], false);
				});

			},

			layers : {

				current: null,

				create : function(opt){

					switch (opt.type) {

						case 'text':

							var text = customdesign.objects.text(opt.ops);

							customdesign.stage().canvas.add(text).setActiveObject(text).renderAll();
							customdesign.tools.set(text);
							customdesign.design.layers.build();

						break;

						case 'image':

							customdesign.stage().canvas.add(opt.image).setActiveObject(opt.image).renderAll();

							customdesign.tools.set(opt.image);

							customdesign.design.layers.build();

						break;

					}

					customdesign.stack.save();

				},

				arrange : function() {

					var canvas = customdesign.stage().canvas,
						active = canvas.getActiveObject();

					if (!active)
						return;

					var objects = canvas.getObjects(),
						index = objects.indexOf(active),
						btn = $('#customdesign-top-tools li[data-tool="arrange"] button[data-arrange]');

					if (
						objects[index-1] !== undefined &&
						objects[index-1].evented !== false
					)
						btn.filter('[data-arrange="back"]').removeClass('disabled');
					else
						btn.filter('[data-arrange="back"]').addClass('disabled');

					if (
						objects[index+1] !== undefined &&
						objects[index+1].evented !== false
					)
						btn.filter('[data-arrange="forward"]').removeClass('disabled');
					else
						btn.filter('[data-arrange="forward"]').addClass('disabled');

				},

				sort : function(el){

					var L = customdesign.design.layers, events = {

				        dragstart : function( e ){
					    	L.eldrag = this;
					    	this.setAttribute('data-holder', 'true');
					    	this.parentNode.setAttribute('data-holder', 'true');
					    },
				        dragover : function(e){

					        L.elover = this;

					        if (this == L.eldrag){
						        e.preventDefault();
								return false;
					        }

					        var rect = this.getBoundingClientRect();

					        if (rect.bottom - e.clientY < (rect.height/2) && $(this).next().get(0) !== L.eldrag)
					        	$(this).after(L.eldrag);
					        else if (rect.bottom - e.clientY > (rect.height/2) && $(this).prev().get(0) !== L.eldrag)
					        	$(this).before(L.eldrag);

					        e.preventDefault();
					        return false;
				        },

				        dragleave : function( e ){
					        e.preventDefault();
					        return false;
				        },
				        dragend : function( e ){

					        L.eldrag.removeAttribute('data-holder');
					        L.eldrag.parentNode.removeAttribute('data-holder');

					        var items = customdesign.e.layers.find('li[data-id]'),
					        	total = customdesign.stage().canvas.getObjects().length-1;

					        items.each(function(i){
								$(this).data('canvas').moveTo(total-i);
					        });

					        L.build();

					        e.preventDefault();
					        return false;
				        }

			        };

			        for (var ev in events)
			        	el.addEventListener(ev, events[ev], false);

				},

				item : function(o) {

					if (!o.id) {
						var date = new Date();
						o.set('id', parseInt(date.getTime()/1000).toString(36)+':'+(Math.random().toString(36).substr(2)));
					}

					var thumbn = o.get('thumbn');

					o.fill = (o.fill == 'rgb(0,0,0)' ? '#000' : o.fill);

					var args = {
						name: '',
						thumbn: thumbn,
						color: o.fill ? customdesign.fn.invert(o.fill) : '#eee',
						bgcolor: o.fill ? o.fill : '#333',
						class: o.active ? 'active' : '',
						visible: (o.visible !== undefined && o.visible === false) ? 'data-active="true" ' : '',
						selectable: (o.selectable !== undefined && o.selectable === false) ? 'data-active="true" ' : '',
						id: o.id
					};

					var name = o.name ? o.name : (o.text ? o.text : 'New layer');
					args.name = name.substr(0, 20).replace(/\n/g, ' ').replace(/[^a-z0-9A-Z ]/g, '');

					if (o.type == 'path')
						args.name = 'Drawing';

					return args;

				},

				build : function() {

					if (!customdesign.get.el('left').find('li[data-tab="layers"]').hasClass('active'))
						return this.arrange();

					var tmpl = "<li draggable=\"true\" class=\"%class%\" data-id=\"%id%\">\
							%thumbn%\
							<span class=\"layer-name\" contenteditable=\"true\" title=\"%name%\">%name%</span> \
							<span class=\"layer-func\">\
								<i class=\"customdesign-icon-eye\" %visible%title=\""+customdesign.i('14')+"\" data-act=\"visible\"></i>\
								<i class=\"customdesign-icon-lock-open\" %selectable%title=\""+customdesign.i('15')+"\" data-act=\"selectable\"></i>\
								<i class=\"customdesign-icon-close\" title=\""+customdesign.i('16')+"\" data-act=\"delete\"></i>\
							</span>\
						</li>",
						layers = customdesign.get.el('layers>ul').html(''), 
						index = 0, 
						is_empty = true,
						stage = customdesign.stage();
					
					if (stage === undefined)
						return; 
						
					stage.canvas.getObjects().map(function(o) {

						if (o.evented === false)
							return index++;

						is_empty = false;

						var args = customdesign.design.layers.item(o), tmp = tmpl;

						Object.keys(args).map(function(n){
							tmp = tmp.replace(new RegExp('%'+n+'%', 'g'), args[n]);
						});

						var layer = $(tmp);

						layers.prepend(layer.data({canvas: o}).on('click', function(e){

							e.preventDefault();
							customdesign.ops.preventClick = true;

							var act = e.target.getAttribute('data-act'),
								evt = customdesign.design.layers.event,
								stage = customdesign.stage(),
								target = $(this).data('canvas');

							if (act && evt[act])
								return evt[act](this, e.target);
							
							if (target.selectable !== false) {
								if ($(this).hasClass('active'))
									return;
								$(this.parentNode).find('li.active').removeClass('active');
								stage.limit_zone.set('visible', true);
								stage.canvas.setActiveObject(target);
							}

						}));

						layer.find('span.layer-name').on('keyup', function(e){

							$(this.parentNode).data('canvas').name = this.innerText;

							if (e.keyCode === 13) {
								e.preventDefault();
								customdesign.design.layers.build();
								return false;
							}

						});

						customdesign.design.layers.sort(layer.get(0));

					});

					if (is_empty)
						customdesign.get.el('layers>ul')
								  .html('<h3 class="mt2" style="border:none;text-align:center">'+customdesign.i('06')+'</h3>');
					else
						customdesign.design.layers.arrange();

				},

				event : {

					visible: function(el, tar) {
						tar.setAttribute('data-active', (tar.getAttribute('data-active') != 'true'));
						$(el).data('canvas').set('visible', (tar.getAttribute('data-active') != 'true'));
						customdesign.objects.do.deactiveAll();
					},

					selectable: function(el, tar) {
						tar.setAttribute('data-active', (tar.getAttribute('data-active') != 'true'));
						$(el).data('canvas').set('selectable', (tar.getAttribute('data-active') != 'true'));
						customdesign.objects.do.deactiveAll();
					},

					delete: function(el, tar) {

						canvas = customdesign.stage().canvas;
						canvas.discardActiveGroup();
						canvas.discardActiveObject();

						customdesign.stack.save();

						canvas.remove($(el).data('canvas'));

						customdesign.stack.save();

						customdesign.design.layers.build();

					}
				}

			},
			
			my_designs : {
				
				import : function(file) {
					
					if (
						typeof file != 'object' || 
						(
							file.type.indexOf('application/json') !== 0 && 
							file.name.substr(file.name.length-5) != '.json' &&
							file.name.substr(file.name.length-5) != '.lumi'
						)
					)return alert(customdesign.i(32));

					if (customdesign.cliparts.uploads[file.lastModified] === undefined) {

						var reader = new FileReader();
						reader.addEventListener("load", function () { 
							
							try{
								var data = JSON.parse(decodeURIComponent(this.result));
							}catch(ex){
								return customdesign.fn.notice(ex.message, 'error', 3500);
							}

							if (data.stages === undefined)
								return customdesign.fn.notice(customdesign.i(32), 'error', 3500);
							
							customdesign.tools.imports(data);

					    	delete reader;

						}, false);

						reader.readAsText(file);

					}
				},
				
				pre_save : () => {
					
					$('#customdesign-navigations').attr({"data-navigation" : "active"});
					$('ul#customdesign-saved-designs').attr({'is' : "save"});
					$('li[data-tool="designs"][data-callback="designs"]').
						addClass('active').
						find('ul[data-view="sub"] header').
						after('<h3>'+customdesign.i('211')+'</h3>');
					
					customdesign.render.refresh_my_designs(true);
					
				}
				
			},
			
			nav : {
				
				callback : {

					layers: function() {
						customdesign.design.layers.build();
					},

					textFX: function(el, e, ratio){
						e.data.textFX(el, e, ratio);
					},
					
					replace : function(el, e) {
						
						var active = customdesign.stage().canvas.getActiveObject();
						
						if (!active)
							return;
							
						customdesign.fn.select_image(function(opt) {
							
							customdesign.fn.replace_image(opt.url, active);
							
						}, false /*do not save to uploaded list*/);
						
						
						e.preventDefault();	
					},
										
					crop: function(el, e){

						var s = customdesign.get.stage(),
							src = s.active.full_src ? s.active.full_src : (
									s.active.fxOrigin ? s.active.fxOrigin.src :
									(s.active._element ? s.active._element.src : s.active._cacheCanvas.toDataURL())
								);
								
						customdesign.fn.crop({
							src: src,
							width: Math.round(s.active.width),
							save: function(crop) {
								
								var s = customdesign.stage(),
									active = s.canvas.getActiveObject(),
									el = crop.find('.customdesign_crop_selArea');
	
								if (active) {
	
									var _e = el.get(0), 
										_c = crop.get(0),
										img = crop.find('img.customdesign_crop_img').get(0),
										cv = document.createElement('canvas'),
										ctx = cv.getContext('2d'),
										type = customdesign.fn.get_type(img.src),
										
										w = img.naturalWidth*(_e.offsetWidth/_c.offsetWidth),
										h = img.naturalHeight*(_e.offsetHeight/_c.offsetHeight),
										
										iw = active.width*(_e.offsetWidth/_c.offsetWidth),
										ih = active.height*(_e.offsetHeight/_c.offsetHeight);
									
									cv.width = w;
									cv.height = h;
									
									ctx.drawImage(
										img, 
										-_e.offsetLeft*(img.naturalWidth/_c.offsetWidth),
										-_e.offsetTop*(img.naturalHeight/_c.offsetHeight),
										img.naturalWidth, 
										img.naturalHeight
									);
									
									var src = cv.toDataURL('image/'+type);
									
									delete cv;
									delete ctx;
									
									if (
										w > s.limit_zone.width ||	
										h > s.limit_zone.height
									) {
										setTimeout(customdesign.fn.large_image_helper, 1, {
											w: w,
											h: h,
											ew: s.limit_zone.width,
											eh: s.limit_zone.height,
											iw: active.width*(_e.offsetWidth/_c.offsetWidth),
											ih: active.height*(_e.offsetHeight/_c.offsetHeight),
											el: cv,
											obj: active,
											src: src
										});
									} else {
										active.setSrc(src, function() {
											active.set({
												full_src: '',
												width: iw,
												height: ih,
												origin_src: src,
												src: src,
												type: 'image'
											});
											s.canvas.renderAll();
										});
									}
								}
								
							}
						});

					},

					select_mask: function(el, e) {
						
						var $this = $(el);

						var s = customdesign.get.stage(),
							objs = s.canvas.getObjects(),
							wrp = $this.find('li[data-view="list"]');

						wrp.html('');

						if (!s.active)
							return;
						
						objs.map(function(o) {
							if (o.evented !== false && o.active !== true){
								var args = customdesign.design.layers.item(o);
								wrp.append('<span data-id="'+o.id+'">'+args.thumbn.replace('%color%', '').replace('%bgcolor%', '')+' '+args.name+'</span>');
							}
						});

						if (wrp.html() === '') {
							wrp.html('<p><center>'+customdesign.i('07')+'</center></p>');
						} else {

							wrp.find('>span').on('click', function(){

								var id = this.getAttribute('data-id'),
									tar = objs.filter(function(o){ return o.id == id; })[0];

								if (
									tar.left - (tar.width/2) > s.active.left + (s.active.width/2) ||
									tar.left + (tar.width/2) < s.active.left - (s.active.width/2) ||
									tar.top - (tar.height/2) > s.active.top + (s.active.height/2) ||
									tar.top + (tar.height/2) < s.active.top - (s.active.height/2)
								){
									return alert(customdesign.i('08'));
								};

								customdesign.stack.save();
								customdesign.ops.importing = true;
								tar.setCoords();
								
								var next_step = function() {
									var arect = s.active.getBoundingRect(),
										brect = tar.getBoundingRect();
	
									var group = [];
									delete tar.clipTo;
									tar.set({
										scaleX: tar.scaleX*5,
										scaleY: tar.scaleY*5,
									});
									
									group.push(tar);
									
									let new_group = new fabric.Group(group, {}),
										psize = customdesign.get.size();
									
									let mask = {
											left: (brect.left-arect.left)/arect.width,
											top: (brect.top-arect.top)/arect.height,
											width: brect.width/arect.width,
											height: brect.height/arect.height,
											dataURL: new_group.toDataURL({
												multiplier: (psize.h/customdesign.stage().limit_zone.height)/
															(window.devicePixelRatio > 2 ? window.devicePixelRatio*2 : window.devicePixelRatio)
											})
										};
	
									$(this).remove();
									s.canvas.remove(tar);
	
									customdesign.fn.update_image_fx('mask', mask, function(){
										customdesign.ops.importing = false;
										customdesign.stack.save();
									});
								};
								
								if (tar.full_src && tar.full_src !== tar.origin_src)
									return tar.setSrc(tar.full_src, next_step);
								
								next_step();

							});

						}
					},

					qrcode: function(){
						
						var fill_default = customdesign.get.color('invert');
			
						if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
							fill_default = customdesign.data.colors.split(',')[0];
							if (fill_default.indexOf(':') > -1)
								fill_default = fill_default.split(':')[1];
							fill_default = fill_default.split('@')[0];
						};
						
						customdesign.objects.qrcode(customdesign.i('09'), fill_default, function(obj){
							customdesign.get.el('top-tools').
								find('li[data-tool="qrcode-text"]').
								addClass('active').
								find('textarea').focus();
						});
						return;

						customdesign.tools.lightbox({
							width: 500,
							content: '<div id="customdesign-create-qrcode" class="customdesign-lightbox-form">\
										<h3 class="title">'+customdesign.i('10')+'</h3>\
										<p>\
											<label>'+customdesign.i('11')+':</label>\
											<input name="text" type="text" placeholder="'+customdesign.i('11')+'" /></p>\
										<p>\
											<label>'+customdesign.i('12')+':</label>\
											<input name="color" type="search" placeholder="'+customdesign.i('13')+'" value="'+fill_default+'" />\
										</p>\
										<p class="right"><button class="primary">'+customdesign.i('10')+'</button></p>\
									</div>'
						});

						new jscolor.color(customdesign.fn.q('#customdesign-create-qrcode input[name="color"]'), {});
						$('#customdesign-create-qrcode button').on('click', function(e){

							var text = customdesign.fn.q('#customdesign-create-qrcode input[name="text"]').value,
								color = customdesign.fn.q('#customdesign-create-qrcode input[name="color"]').value;

							if (text === '')
								return $('#customdesign-create-qrcode input[name="text"]').shake();
							if (color === '')
								return $('#customdesign-create-qrcode input[name="color"]').shake();

							customdesign.objects.qrcode(text, color);
							customdesign.get.el('left .customdesign-left-nav li[data-tab="layers"]').trigger('click');

						});
						customdesign.fn.q('#customdesign-create-qrcode input[name="text"]').focus();

					},

					drawing: function(el, e) {

						var canvas = customdesign.stage().canvas;
						var fill_default = customdesign.get.color('invert');
			
						if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
							fill_default = customdesign.data.colors.split(',')[0];
							if (fill_default.indexOf(':') > -1)
								fill_default = fill_default.split(':')[1];
							fill_default = fill_default.split('@')[0];
						};
						
						if (!canvas.isDrawingMode)
							return;

						canvas.freeDrawingBrush.width = parseFloat(customdesign.get.el('drawing-width').val());
						canvas.freeDrawingBrush.color = customdesign.get.el('drawing-color').val() ?
														customdesign.get.el('drawing-color').val() :
														fill_default;
					},

					imageFXReset: function() {

						var s = customdesign.get.stage();
						if (!s.active || !s.active.fxOrigin)
							return customdesign.tools.discard();

						customdesign.stack.save();

						delete s.active.fx;

						s.active._element.src = s.active.fxOrigin.src;
						s.active._originalElement.src = s.active.fxOrigin.src;

						s.canvas.renderAll();
						customdesign.tools.discard();


					},

					designs: function(){
						
						$('ul#customdesign-saved-designs').removeAttr('is');
						$('li[data-tool="designs"][data-callback="designs"]>ul[data-view="sub"]>h3').remove();
						
						return customdesign.render.refresh_my_designs();
						
						if (!$('#customdesign-saved-designs').attr('data-load')) {
							customdesign.render.refresh_my_designs();
							$('#customdesign-saved-designs').attr({'data-load': 'true'});
						}

					},
					
					proceed: function(el, e) {
						
						var printings = customdesign.get.el('cart-wrp').find('input[name="printing"].customdesign-cart-param'),
							prtsel = printings.filter(function() {
								return $(this).prop('checked');
							});
							
						if (printings.length > 0 && prtsel.length === 0)
							printings.eq(0).prop({'checked': true}).trigger('change');
							
					},
					
					svg : function(el, e) {
						
						if (e.target.tagName == 'INPUT' && e.target.getAttribute('data-color')) {
							
							var se = customdesign.get.el('svg-fill').get(0),
								cl = e.target.getAttribute('data-color');
								
							se.setAttribute('data-active-color', e.target.getAttribute('data-color'));
							/*if (se.color && typeof se.color.fromString == 'function')
								se.color.fromString(cl);*/
							se.value = cl;
							se.style.background = cl;
							se.style.color = customdesign.tools.svg.invertColor(cl);
							
							customdesign.get.el('svg-colors').addClass('active');
							
							return;
							
						}else if (e.target.getAttribute('data-func') == 'editor'){
							customdesign.tools.svg.edit();
						};
						
						customdesign.get.el('svg-colors').removeClass('active');
						
					},
					
					group : function(el, e) {
						
						var stage = customdesign.stage(),
							group = stage.canvas.getActiveGroup(),
							tel = $('#customdesign-top-tools ul[data-mode="group"]'),
							gr = tel.attr('data-grouped'),
							id = new Date().getTime().toString(36);
						
						if (group && group._objects) {
							group._objects.map(function(o) {
								if (gr == 'false')
									o.set({group_pos: id});
								else o.set({group_pos: null});
							});
							$('#customdesign-top-tools ul[data-mode="group"]').attr({'data-grouped': gr == 'false' ? 'true' : 'false'});
						};
						
						e.preventDefault();
						
					},
					
					ungroup: function(el, e) {
						customdesign.stage().canvas.getActiveObject().set({'group_pos': null});
						el.style.display = 'none';
					}
					
				},

				load : {

					cliparts: function() {

						customdesign.post({
							action: 'cliparts',
							category: ''
						});

					},
					
					templates: function() {

						customdesign.post({
							action: 'templates',
							category: ''
						});

					},

					images: function(){

						$('#customdesign-uploads div[data-tab="internal"]').trigger('scroll');

					},

					shapes: function(){

						$('#customdesign-shapes').trigger('scroll');

					}

				}
				
			}

		},
		
		xitems : {
			
			ops : {},
			
			resources : {},
			
			load : function(comp, ops) {
				
				this.resources[comp] = {
					url: [],
					ops: ops
				};
				
				customdesign.post({
					action: 'addon',
					component: comp,
					category: '',
					rayid: Math.random()
				}, function(res) {
					
					if (typeof ops.load == 'function')
						res = ops.load(res);
						
					customdesign.xitems.response(res, comp);
						
				});
			},
			
			response: function (res, comp) {
				
				if (typeof customdesign.xitems.resources[comp].ops.response == 'function')
					res = customdesign.xitems.resources[comp].ops.response(res);
				
				var html = '', wrp = $('#customdesign-'+comp+'-list');
						
				if (res.items && res.items.length > 0) {
					
					res.items.map(function(item) {
						
						customdesign.xitems.resources[comp].url[item.id] = customdesign.data.upload_url+item.upload;
					
						html += '<li style="background-image: url(\''+(
								item.thumbnail_url !== undefined ? 
								item.thumbnail_url : 
								item.screenshot
							)+'\')" \data-ops=\'[{'+
									'"type": "'+customdesign.xitems.resources[comp].ops.preview+'",'+
									'"component": "'+comp+'",'+
									'"name": "'+item.name+'",'+
									'"id": "'+item.id+'",'+
									'"tags": "'+(item.tags?item.tags:'')+'",'+
									'"cates": "'+(item.cates?item.cates:'')+'",'+
									'"resource": "backgrounds",'+
									'"resource_id": "'+item.id+'",'+
									'"price": "'+item.price+'",'+
									'"screenshot": "'+(
										item.thumbnail_url !== undefined ? 
										item.thumbnail_url : 
										item.screenshot
									)+'"'+
								'}]\' class="customdesign-xitem">'+
									'<i data-tag="'+item.id+'">'+(
										item.price > 0 ? 
										customdesign.fn.price(item.price) : 
										customdesign.i(100)
									)+'</i>'+
									'<i data-info="'+item.id+'"></i>'+
								'</li>';
					});
					
					var total = res.total ? res.total : 0;
					
					customdesign.ops[comp+'_q'] = res.q;
					customdesign.ops[comp+'_category'] = res.category;
					customdesign.ops[comp+'_index'] = parseInt(res.index)+res.items.length;
					
					if (customdesign.ops[comp+'_index']<total)
						customdesign.ops[comp+'_loading'] = false;
	
				}else html += '<span class="noitems">'+customdesign.i(42)+'</span>';
	
				wrp.find('i.customdesign-spinner').remove();
				wrp.find('ul.customdesign-list-items').append(html);
				
				customdesign.render.categories(comp, res);
				
				wrp.find('ul.customdesign-list-items li.customdesign-xitem:not([data-event="true"])').off('click').on('click', function(e) {
						
					e.preventDefault();
					
					var o = JSON.parse(this.getAttribute('data-ops'))[0];
					
					o.url = customdesign.xitems.resources[comp].url[o.id];
					
					if (
						customdesign.xitems.resources[comp].ops !== undefined && 
						typeof customdesign.xitems.resources[comp].ops.click == 'function'
					)customdesign.xitems.resources[comp].ops.click(o, this);
					
				});
				
			},
			
			scroll_more : function(e) {
				
				var comp = this.getAttribute('data-component');
				
				if (!comp || customdesign.ops[comp+'_loading'] === true)
					return;

				if (this.scrollTop + this.offsetHeight >= this.scrollHeight/* - 100*/) {
					
					customdesign.post({
						action: 'addon',
						component: comp,
						category: customdesign.ops[comp+'_category'],
						q: customdesign.ops[comp+'_q'],
						index: customdesign.ops[comp+'_index']
					}, function(res) {
						customdesign.xitems.response(res, comp);
					});
					
					$(this).append('<i class="customdesign-spinner white x3 mt1 mb1"></i>');
					customdesign.ops[comp+'_loading'] = true;
					
				}


			},
			
			search : function(e) {
				
				var comp = this.getAttribute('data-component');
				
				if (e.type == 'click') {
					setTimeout(function(el){
						if (customdesign.ops[comp+'_q'] != el.value && el.value === '') {
							customdesign.ops[comp+'_q'] = el.value;
							customdesign.xitems.do_search(comp);
						}
					}, 100, this);
				}
				
				if (this.tagName == 'INPUT' && e.keyCode !== 13)
					return;

				if (this.tagName == 'INPUT')
					customdesign.ops[comp+'_q'] = this.value;
				
				customdesign.xitems.do_search(comp);

			},
			
			do_search: function(type) {
				
				customdesign.ops[type+'_index'] = 0;
				customdesign.ops[type+'_loading'] = false;

				customdesign.get.el(type+'-list').find('ul').html('');
				customdesign.get.el(type+'-list').trigger('scroll');
				
			}
			
		},
		
		templates : {
			
			storage : [],
			
			add_events : function() {

				var events = [['click', function(e){

					customdesign.itemInStage('add');
					
					var t = this, 
						ops = JSON.parse(this.getAttribute('data-ops'));
						
					if (customdesign.templates.storage[ops[0].id]) {
						customdesign.templates.load({
							upload: customdesign.templates.storage[ops[0].id],
							id: ops[0].id,
							price: ops[0].price
						});
						if (customdesign.stage().template !== undefined)
							customdesign.stage().template.loaded = true;
					}
	
				}]];
	
				customdesign.get.el('left').find('ul.customdesign-list-items li.customdesign-template:not([data-event="true"])').each(function(){
	
					if (this.getAttribute('data-event'))
						return;
	
					this.setAttribute('data-event', true);
					
					var _this = this;
					events.map(function(ev){
						_this.addEventListener(ev[0], ev[1], false);
					});
				});
			},
			
			load : function(tmp, callback) {
				
				if (tmp.upload === undefined) {
					if (customdesign.ops.first_completed !== true) {
						customdesign.actions.do('first-completed');
						customdesign.ops.first_completed = true;
					};
					return;
				};
				
				let ext = tmp.upload.split('.').pop();
				
				if (ext == 'lumi') {
					
					if (tmp.upload.toString().trim().indexOf('http') !== 0)
						tmp.upload = customdesign.data.upload_url+tmp.upload;
						
					customdesign.f(customdesign.i('loading')+'..');
					
					$.ajax({
						url: tmp.upload,
						method: 'GET',
						statusCode: {
							403: customdesign.response.statusCode[403],
							404: function(){
								customdesign.fn.notice(customdesign.i(83), 'error', 3500);
								customdesign.f(false);
							},
							200: function(res) {
								customdesign.templates.response(res, tmp, callback);
							}
						}
					});
					
				} else {
					
					customdesign.f(customdesign.i('loading')+'..');
					
					var templ = new Image();
					
					templ.onerror = function () {
						customdesign.f(false);
						customdesign.fn.notice('Error on loading template file', 'error');
					};
					
					templ.onload = function() {
						var res = customdesign.fn.build_lumi(this);
						customdesign.templates.response(res, tmp, callback);
					};
					
					templ.src = tmp.upload.startsWith('https://') || tmp.upload.startsWith('http://') ? tmp.upload :   customdesign.data.upload_url+tmp.upload;
						
				}
					
			},
			
			response : function(res, tmp, callback) {
				
				try {
					if (typeof res === ' string' || res.stages === undefined)
						res = JSON.parse(decodeURIComponent(typeof res === 'string' ? res : res.responseText));
				}catch(ex) {
					console.warn(ex);
					console.log(ex);
					customdesign.f(false);
					return;
				};
				
				if (typeof res !== 'object' || res.stages === undefined || res.stages.length === 0)
					return false;
				
				if (res.stages.customdesign === undefined)
					res.stages.customdesign = res.stages[Object.keys(res.stages)[0]];
				
				if (typeof res.stages.customdesign.data == 'string')
					res.stages.customdesign.data = JSON.parse(res.stages.customdesign.data);
				
				var objects = res.stages.customdesign.data.objects;
					
				if (objects !== undefined) {	
					for (var item in objects){
						if(
							objects[item] !== null &&
							typeof objects[item]['type'] !== 'undefined'
						){
							objects[item]['price'] = 0;
							objects[item]['template'] = [tmp.id, !isNaN(tmp.price) ? parseFloat(tmp.price) : 0];
						}
					}
				};
				
				customdesign.cart.template[customdesign.current_stage] = [];
				customdesign.cart.price.template[customdesign.current_stage] = 0;
				
				res.clear = tmp.clear;
				
				customdesign.actions.do('template', tmp, res);
				
				if (res.stages.customdesign !== undefined && res.stages.customdesign.padding === undefined) {
					res.stages.customdesign.padding = customdesign.fn.calc_padding(res.stages.customdesign);
				};
				
				customdesign.tools.imports(res, function(stage) {
					
					if (
						stage.template !== undefined && 
						stage.template.offset !== undefined &&
						stage.template.scale !== undefined &&
						stage.template.loaded !== true
					) {
						
						var stage = customdesign.stage(),
							scale = stage.template.offset.width/stage.edit_zone.width,
							scl = stage.limit_zone.width/stage.edit_zone.width,
							left = stage.template.offset.left*scl,
							top = stage.template.offset.top*scl;
						
						if (res.stages.customdesign !== undefined && res.stages.customdesign.padding !== undefined) {
							left += res.stages.customdesign.padding[0]*stage.template.offset.width*scl;
							top += res.stages.customdesign.padding[1]*stage.template.offset.height*scl;
						}
						
						customdesign.fn.scale_designs(scale, {left: left, top: top});
						stage.template.loaded = true;
						
					};
					
					if (customdesign.ops.first_completed !== true) {
						customdesign.actions.do('first-completed');
						customdesign.ops.first_completed = true;
					};
					
					if (typeof callback === 'function')
						callback();
					
				});
				
			}
		},
		
		cliparts : {

			storage : [],

			uploads : [],

			add : function(el, ops) {
				
				if (!el.getAttribute('data-ops'))
					return;
				
				customdesign.ops.preventClick = true;

				customdesign.f(customdesign.i('loading')+'..');

				var ops = $.extend(JSON.parse(el.getAttribute('data-ops')), (ops ? ops : {}), true),
					sto = ops.type == 'image' ? customdesign.cliparts.storage[ops.id] : (customdesign.cliparts.uploads[ops.id] || {}),
					stage = customdesign.stage();

				if (ops.type == 'shape')
					sto.url = 'data:image/svg+xml;base64,'+btoa(el.innerHTML.trim());

				sto.width = sto.width ? sto.width : stage.limit_zone.width*0.8;

				if (ops.text && !ops.name)
					ops.name = ops.text.substr(0, 30);

				if (sto.url){
					if (sto.url.indexOf('data:image/svg+xml;base64,') > -1 || sto.url.split('.').pop().trim() == 'svg') {
						ops.type = 'svg';
					}else ops.type = 'image';
				}

				ops = $.extend({
					left: stage.limit_zone.left + (stage.limit_zone.width/2),
					top: stage.limit_zone.top + (stage.limit_zone.height/2),
					width: sto.width,
					name: sto.name ? sto.name : (
						sto.url && sto.url.indexOf('data:image') === -1 ?
						sto.url.split('/').pop() :
						ops.type == 'svg' ? 'New SVG' : 'New Image'
					)
				}, ops);
				
				var fill_default = customdesign.get.color('invert');
				
				if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
					fill_default = customdesign.data.colors.split(',')[0];
					if (fill_default.indexOf(':') > -1)
						fill_default = fill_default.split(':')[1];
					fill_default = fill_default.split('@')[0];
				};
				
				if (ops.type == 'i-text') {
					
					ops.fill = fill_default;
					
					customdesign.design.layers.create({type: 'text', ops: ops});
					customdesign.f(false);
					return;
				}else if (ops.type == 'text-fx') {
					ops.fill = fill_default;
				};
				
				fabric.Image.fromURL(sto.url, function(image) {

					customdesign.f(false);

					if (ops.height === undefined)
						ops.height = image.height * (sto.width/image.width),

					ops.clipTo = function(ctx) {
			            return customdesign.objects.clipto(ctx, image);
			        };

					image.set(ops);

					customdesign.design.layers.create({
						type: 'image',
						src: sto.url,
						image: image
					});

					customdesign.get.el('x-thumbn-preview').hide();

					stage.canvas.setActiveObject(image);

				});

			},

			add_events : function() {

				var events = [['dragstart', function(e){

					customdesign.ops.drag_start = this;

					var offs = $(this).offset();

					customdesign.ops.drag_start.distance = {
						x : (e.pageX - offs.left) - (this.offsetWidth/2),
						y : (e.pageY - offs.top) - (this.offsetHeight/2),
						w : this.offsetWidth,
						h : this.offsetHeight
					};

					customdesign.get.el('x-thumbn-preview').hide();

				}],
				['dragend', function(e){

					customdesign.ops.drag_start = null;

				}],
				['click', function(e){

					customdesign.itemInStage('add');

					var del = e.target.getAttribute('data-delete');
					if (del) {
						if (confirm(customdesign.i('sure'))) {
							$(this).remove();
							URL.revokeObjectURL($(e.target).parent().find('img').attr('src'));
							delete customdesign.cliparts.uploads[del];
							return customdesign.indexed.delete(del, 'uploads');
						}
					}

					var t = this, 
						ops = this.getAttribute('data-ops');
					
					if (customdesign.xitems.ops[ops] !== undefined)
						ops = $.extend(true, [], customdesign.xitems.ops[ops]);
					else ops = JSON.parse(ops);
					
					if (ops[0].type == 'shape')
						ops[0].url = 'data:image/svg+xml;base64,'+btoa(t.innerHTML.trim());
					else if (ops[0].url === undefined)
						ops[0].url = customdesign.cliparts.storage[ops[0].id] || customdesign.cliparts.uploads[ops[0].id];
					
					if (ops[0].url && ops[0].url.indexOf('dumb-') === 0) {
						customdesign.indexed.get(ops[0].url.split('dumb-')[1], 'dumb', function(res){
							if (res !== null & res !== undefined) {
								customdesign.cliparts.uploads[ops[0].id] = res[0];
								ops[0].url = res[0];
								ops[0].user_upload = true;
								customdesign.fn.preset_import(ops, {});
								delete res;
							} else customdesign.fn.notice(customdesign.i(165));
						});
					} else {
						customdesign.fn.preset_import(ops, {});
					}
					
				}]];

				customdesign.get.el('left').find('ul.customdesign-list-items li.customdesign-clipart:not([draggable="true"])').each(function(){

					if (this.getAttribute('draggable'))
						return;

					this.setAttribute('draggable', true);
					var _this = this;
					events.map(function(ev){
						_this.addEventListener(ev[0], ev[1], false);
					});
				});
			},

			external : function(url, callback) {

				var image = new Image();

				image.crossOrigin = "Anonymous";
				image.onload = function () {

					var canvas = document.createElement('canvas');

				    canvas.width = this.naturalWidth;
				    canvas.height = this.naturalHeight;
				    canvas.getContext('2d').drawImage(this, 0, 0);
				    this.callback(canvas);//.toDataURL('image/jpeg')

				    delete this;
				    delete canvas;
				};

				image.callback = callback;
				image.src = url;

			},

			import : function(id, ops, dir) {
				
		    	var do_import = function() {
					
					customdesign.cliparts.uploads[id] = ops.url;

				    if (ops.thumbn && typeof ops.thumbn == 'string' && ops.thumbn.indexOf('data:image') === 0)
				    	ops.thumbn = customdesign.fn.url2blob(ops.thumbn);

			    	if (ops.save !== false) {
			    		try{
				    		customdesign.indexed.save([{
					    		thumbn: ops.thumbn,
					    		name: ops.name,
					    		id: id
					    	}, [ops.url]], 'uploads');
				    	}catch(ex){console.log(ex);}
			    	}

			    	var html = '<li style="background-image: url(\''+URL.createObjectURL(ops.thumbn ? ops.thumbn : ops.url)+'\')" \
			    				data-ops=\'[{"type": "upload", "name": "'+ops.name+'", "id": "'+id+'"}]\' class="customdesign-clipart">\
								<i data-info="'+id+'"></i>\
								<i class="customdesign-icon-close" data-delete="'+id+'" title="'+customdesign.i(47)+'"></i>\
							</li>';

			    	if (dir == 'prepend')
			    		customdesign.get.el('upload-list').find('ul.customdesign-list-items').prepend(html);
			    	else customdesign.get.el('upload-list').find('ul.customdesign-list-items').append(html);

			    	customdesign.cliparts.add_events();

		    	};

	    		if (ops.thumbn === undefined) {

		    		customdesign.fn.createThumbn({
			    		source: ops.url,
			    		width: 300,
			    		height: 240,
			    		callback: function(canvas) {
				    		ops.thumbn = customdesign.fn.url2blob(canvas.toDataURL('image/jpeg', 0.3));
				    		do_import();
			    		}
		    		});

		    		return;
	    		};

		    	do_import();


		    }

		},

		actions : {

			stack : [],

			add : function(name, callback, priority) {
				
				if (priority === undefined)
					priority = 10;
					
				if (this.stack[priority] === undefined)
					this.stack[priority] = {};
					
				if (this.stack[priority][name] === undefined)
					this.stack[priority][name] = [];

				this.stack[priority][name].push(callback);

			},

			do : function(name, opts, p) {
				
				customdesign.actions.stack.map(function(stack) {
					if (stack[name] !== undefined) {
						var res;
						stack[name].map(function(evt){
							if (typeof evt == 'function') {
								try { 
									res = evt(opts, p);
								}catch(ex){
									console.warn(ex.message+' - do action '+name);
									console.log(ex);
									customdesign.fn.notice(ex.message+' - do action '+name, 'error');
								}
							}
						});
						return res;
					}
				});

			}

		},

		tools : {

			set : function(obj) {

				if (!obj)
					obj = customdesign.stage().canvas.getActiveObject();

				if (!obj)
					return;
					
				var el = customdesign.get.el;

				el('transparent').val(obj.opacity !== undefined && obj.opacity !== null ? parseFloat(obj.opacity)*100 : 100).trigger('input');
				el('rotate').val(obj.angle !== undefined ? obj.angle : 0).trigger('input');

				el('curved-radius').val(obj.radius !== undefined ? obj.radius : 50).trigger('input');
				el('curved-spacing').val(obj.spacing !== undefined ? obj.spacing : 50).trigger('input');
				el('workspace').find('.customdesign-edit-text').val(obj.text ? obj.text.trim() : '');
				
				el('font-size').val(obj.fontSize ? obj.fontSize : 14).trigger('input');
				el('letter-spacing').val(obj.charSpacing !== undefined ? obj.charSpacing : 0).trigger('input');
				el('line-height').val(obj.lineHeight !== undefined ? obj.lineHeight*10 : 10).trigger('input');

				if (obj.type == 'path'){
					el('stroke-width').attr({'data-ratio': '1'}).val(obj.strokeWidth !== undefined ? obj.strokeWidth : 0).trigger('input');
				}else{
					el('stroke-width').attr({'data-ratio': '0.1'}).val(obj.strokeWidth !== undefined ? obj.strokeWidth*10 : 0).trigger('input');
				}

				el('skew-x').val(obj.skewX !== undefined ? obj.skewX : 0).trigger('input');
				el('skew-y').val(obj.skewY !== undefined ? obj.skewY : 0).trigger('input');

				if (
					obj.type != 'path' &&
					(
						obj.type != 'image' ||
						(obj.type == 'image' && obj.fill != 'rgb(0,0,0)' && obj.fill !== '#000' && obj.fill !== '')
					) &&
					(
						obj.type != 'svg' ||
						(obj.type == 'svg' && obj.fill != 'rgb(0,0,0)' && obj.fill !== '#000' && obj.fill !== '')
					)
				) {
					
					var fill_default = customdesign.get.color('invert');
				
					if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
						fill_default = customdesign.data.colors.split(',')[0];
						if (fill_default.indexOf(':') > -1)
							fill_default = fill_default.split(':')[1];
						fill_default = fill_default.split('@')[0];
					};
					
					var fill = obj.fill ? obj.fill : fill_default;

					if (el('fill').get(0).color && typeof el('fill').get(0).color.fromString == 'function')
						el('fill').get(0).color.fromString(fill);
					el('fill').closest('li[data-tool="fill"]').css({'border-bottom': '3px solid '+(fill)});

				} else {
					el('fill').val('').attr({style: ''});
					el('fill').closest('li[data-tool="fill"]').css({'border-bottom': ''});
				};

				var stroke = obj.stroke ? obj.stroke : '';
				if (el('stroke').get(0).color && typeof el('stroke').get(0).color.fromString == 'function')
					el('stroke').val(stroke).css({background: ''}).get(0).color.fromString(stroke);
				el('text-tools .text-format').removeClass('selected');
				el('text-tools .text-format.customdesignx-align-'+obj.textAlign).addClass('selected');
				el('text-align').attr({'class': 'customdesignx-align-'+(obj.textAlign ? obj.textAlign : 'center')});

				el('curved').get(0).checked = (obj.type === 'curvedText');
				el('flip-x').get(0).checked = obj.flipX;
				el('flip-y').get(0).checked = obj.flipY;
				el('lock-position').get(0).checked = obj.lockPosition;
				el('position-wrp').attr({'data-lock': obj.lockPosition === true ? 'true' : 'false'});

				el('qrcode-text').val(obj.text ? obj.text.trim() : '');

				var format = el('text-tools .text-format');

				[['bold', 'fontWeight'], ['italic', 'fontStyle'], ['underline', 'textDecoration']].map(function(f){
					if (obj[f[1]] == f[0])
						format.filter('[data-format="'+f[0]+'"]').addClass('selected');
				});

				if (obj.fontFamily){
					
					var fml = obj.fontFamily.replace(/\"/g, '');
					if (el('fonts').find('font[data-family="'+fml+'"]').length > 0) {
						el('fonts').find('.selected').removeClass('selected');
						el('fonts').find('font[data-family="'+fml+'"]').addClass('selected');
					}
					el('text-tools').find('button.dropdown').html('<font style="font-family:\''+fml+'\'">'+fml+'</font>');
				}
				
				el('text-effect').find('img[data-effect]').attr({'data-selected': null});

				if (obj.type == 'text-fx') {

					if (obj.bridge === undefined)
						obj.bridge = {};

					el('text-fx-offsety').val(obj.bridge.offsetY !== undefined ? obj.bridge.offsetY*100 : 50).trigger('input');
					el('text-fx-bottom').val(obj.bridge.bottom !== undefined ? obj.bridge.bottom*10 : 25).trigger('input');
					el('text-fx-curve').val(obj.bridge.curve !== undefined ? obj.bridge.curve*10 : -25).trigger('input');
					el('text-fx-trident').prop({checked: obj.bridge.trident});

					if (obj.bridge.oblique === true)
						el('text-effect').find('img[data-effect="oblique"]').attr({'data-selected': 'true'});
					else el('text-effect').find('img[data-effect="bridge"]').attr({'data-selected': 'true'});

				}else if (obj.type == 'curvedText') {
					el('text-effect').find('img[data-effect="curved"]').attr({'data-selected': 'true'});
				}else if (obj.type == 'text-fx') {
					el('text-effect').find('img[data-effect="normal"]').attr({'data-selected': 'true'});
				}else if (obj.type == 'image') {
					
					el('image-fx-brightness').val(obj.fx && obj.fx.brightness ? obj.fx.brightness : 0).trigger('input');
					el('image-fx-saturation').val(obj.fx && obj.fx.saturation ? obj.fx.saturation : 100).trigger('input');
					el('image-fx-contrast').val(obj.fx && obj.fx.contrast ? obj.fx.contrast : 0).trigger('input');
					el('image-fx-deep').val(obj.fx && obj.fx.deep ? obj.fx.deep : 0).trigger('input');
					el('image-fx-mode').val(obj.fx && obj.fx.mode ? obj.fx.mode : 'light');
					el('image-fx-fx').find('[data-selected]').removeAttr('data-selected');
					el('image-fx-fx').find('li[data-fx="'+(obj.fx && obj.fx.fx ? obj.fx.fx : '')+'"]').attr({'data-selected': 'true'});
				}else if (obj.type == 'svg' && obj.src !== undefined && obj.src.indexOf('data:image/svg+xml;base64,') === 0) { 
					
					customdesign.fn.set_svg_colors(obj);
					
				};

				customdesign.design.layers.arrange();

				if (obj.type == 'image' && obj._element && obj._element.src.indexOf('data:image/svg+xml;base64,') > -1)
					obj.set('type', 'svg');

				customdesign.e.tools.attr({'data-view': obj.type});
				
				el('top-tools').find('li[data-tool="un-group"]').css({display: obj.group_pos ? 'inline-block' : 'none'});
				
				switch (el('text-effect').find('img[data-effect][data-selected="true"]').attr('data-effect')) {
					case 'bridge': 
					case 'oblique': 
						$('[data-tool="text-effect"] li[data-func]').removeAttr('data-active');
						$('[data-tool="text-effect"] li[data-func="text-fx"]').attr({'data-active': 'true'});
					break;
					case 'curved':
						$('[data-tool="text-effect"] li[data-func]').removeAttr('data-active');
						$('[data-tool="text-effect"] li[data-func="curved"]').attr({'data-active': 'true'});
					break;
					default: 
						$('[data-tool="text-effect"] li[data-func]').removeAttr('data-active');
					break;
				}
				
			},

			export : function(stage) {
				
				if (!stage || !stage.canvas)
					return null;

				var data = stage.canvas.toJSON(customdesign.ops.export_list);
				
				data.objects.map(function(obj, ind){

					if (obj.evented === false && obj.type != 'imagebox') {
						delete data.objects[ind];
					} else delete data.objects[ind].clipTo;

					Object.keys(obj).map(function(k){
						if (obj[k] === undefined || obj[k] === null)
							delete obj[k];
					});

					if (obj.fontFamily !== undefined && obj.font === undefined) {
						fonts = JSON.parse(localStorage.getItem('CUSTOMDESIGN_FONTS'));
						if (fonts[encodeURIComponent(obj.fontFamily)])
							obj.font = fonts[encodeURIComponent(obj.fontFamily)];
					};
					
					 if (
					 	obj.fontFamily !== undefined && 
					 	typeof obj.font == 'string' && 
					 	obj.font.indexOf('.woff') > -1 && 
					 	obj.font.indexOf('http') === -1
					 )obj.font = customdesign.data.upload_url+obj.font;
					
					if (obj.fontFamily && obj.fontFamily.indexOf('"') > -1)
						obj.fontFamily = obj.fontFamily.replace(/\"/g, '');
					
					if (obj.origin_src) {
						obj.src = obj.origin_src;
						delete obj.origin_src;
					};

					if (obj.type == 'text-fx' || obj.type == 'i-text' || obj.type == 'curvedText')
						delete obj.src;
						
					if (obj.type == 'path-group') {
						obj.type = 'svg';
						delete obj.paths;
					};

				});
				
				data.devicePixelRatio = window.devicePixelRatio;
				data.product_color = customdesign.get.color();
				data.limit_zone = {};
				data.edit_zone = stage.edit_zone;
				data.product_width = stage.product.width;
				data.product_height = stage.product.height;
				data.screenshot = stage.screenshot;
				
				['width', 'height', 'top', 'left'].map(function(f){
					data.limit_zone[f] = stage.limit_zone ? stage.limit_zone[f] : 0;
				});
				
				data = customdesign.apply_filters('export', data, stage);
				
				return data;

			},

			toImage : function(ops) {

				var s = ops.stage,
					dpr = window.devicePixelRatio !== undefined ? window.devicePixelRatio : 1;

				if (!s || !s.limit_zone)
					return null;
				
				ops = $.extend({
					is_bg: false,
					format: ops.is_bg !== true ? 'png' : 'jpeg',
					multiplier: dpr/2,
					top: s.limit_zone.top,
				    left: s.limit_zone.left,//-(((s.limit_zone.height*(w/h))-s.limit_zone.width)/2),
				    width: s.limit_zone.width,//s.limit_zone.height*(w/h),
				    height: s.limit_zone.height
				}, ops);
				
				ops.multiplier = ops.multiplier/dpr;
				
				if (ops.is_bg == 'full') {
					ops.left = s.product.left-(s.product.width/2);
					ops.top = s.product.top-(s.product.height/2);	
					ops.width = s.product.width;	
					ops.height = s.product.height;
				} else {
					ops.left += 1;
					ops.top += 1;	
					ops.width -= 1;	
					ops.height -= 1;	
				};
				
				if (
					(ops.is_bg === false && ops.with_base !== true) || 
					(
						s.productColor &&
						s.productColor.fill == '#dedede'
					)
				) {
					var bg = s.canvas.backgroundColor;
					s.canvas.backgroundColor = 'transparent';
	
					if (s.productColor)
						s.productColor.visible = false;
				};
				
				if (ops.is_bg === false && ops.with_base !== true) {
					if (s.product)
						s.product.visible = false;
					if (s.canvas.overlayImage)
						s.canvas.overlayImage.visible = false;
				};
				
				var lm = s.limit_zone.visible;
				s.limit_zone.visible = false; 
				
				var data = s.canvas.toDataURL(ops);
				
				if (
					(ops.is_bg === false && ops.with_base !== true) || 
					(
						s.productColor &&
						s.productColor.fill == '#dedede'
					)
				) {
					s.canvas.backgroundColor = bg;
	
					if (s.productColor)
						s.productColor.visible = true;
				};
				
				if (ops.is_bg === false && ops.with_base != 'yes') {
					if (s.product)
						s.product.visible = true;
					if (s.canvas.overlayImage)
						s.canvas.overlayImage.visible = true;

				};
				
				s.limit_zone.visible = lm;
				s.canvas.renderAll();
					
				return data;

			},

			qrcode : function(options) {

				if( typeof options === 'string' ){
					options	= { text: options };
				}

				options	= $.extend( {}, {
					render		: "canvas",
					width		: 500,
					height		: 500,
					typeNumber	: -1,
					correctLevel	: QRErrorCorrectLevel.H,
		            background      : "rgba(255,255,255,0)",
		            foreground      : customdesign.get.color('invert')
				}, options);


				var qrcode	= new QRCode(options.typeNumber, options.correctLevel);
				qrcode.addData(options.text);
				qrcode.make();


				var canvas	= document.createElement('canvas');
				canvas.width	= options.width+50;
				canvas.height	= options.height+50;
				var ctx		= canvas.getContext('2d');


				var tileW	= options.width  / qrcode.getModuleCount();
				var tileH	= options.height / qrcode.getModuleCount();


				for( var row = 0; row < qrcode.getModuleCount(); row++ ){
					for( var col = 0; col < qrcode.getModuleCount(); col++ ){
						ctx.fillStyle = qrcode.isDark(row, col) ? options.foreground : options.background;
						var w = (Math.ceil((col+1)*tileW) - Math.floor(col*tileW));
						var h = (Math.ceil((row+1)*tileW) - Math.floor(row*tileW));
						ctx.fillRect(Math.round(col*tileW)+25,Math.round(row*tileH)+25, w, h);
					}
				}

				return canvas;

			},

			clear : function(){

				this.discard();

				var canvas = customdesign.stage().canvas,
					objs = canvas.getObjects();

				while (objs.filter(function(obj){return obj.evented}).length > 0){
					objs.map(function(obj) {
						if (obj.evented === true)
							canvas.remove(obj);
					});
				}
				
				customdesign.stack.save();
				
			},

			clearAll : function(){

				var canvas, objs;

				Object.keys(customdesign.data.stages).map(function(s){

					canvas = customdesign.data.stages[s].canvas;

					if (canvas === undefined)
						return;

					objs = canvas.getObjects();

					while (objs.filter(function(obj){return obj.evented}).length > 0) {
						objs.map(function(obj) {
							if (obj.evented === true)
								canvas.remove(obj);
						});
					}

				});
				
				customdesign.stack.save();
				
			},

			import : function (data, callback) {
				
				if (!data || !data.objects) {
					customdesign.ops.importing = false;
					return callback();
				};
				
				if (typeof callback != 'function')
					callback = function() {};
				
				data = customdesign.apply_filters('import', data);
				data.objects = data.objects.filter(function(val){return val});
				
				var stage = customdesign.stage(),
					canvas = stage.canvas,
					do_import = function(i) {
						
						if (i === -1) {
							/*Scann and load all fonts before importing*/
							var gfonts = [], custom = [], families = [], cfo, uco;
							/* Life hack, display font for the first time*/
							if ($('#customdesign-fonts-preload').length === 0)
								$('body').append('<div id="fonts-preload" style="position: fixed;opacity: 0;"></div>');
							
							data.objects.map(function(o) {								
								
								if (
									o !== null && 
									o.fontFamily !== undefined && 
									o.fontFamily !== '' && 
									o.fontFamily.toLowerCase() != 'arial'
								) {
									
									cfo = decodeURIComponent(o.fontFamily.replace(/\"/g, ''));
									
									if (families.indexOf(cfo) === -1 && cfo.toLowerCase() != 'arial') {
										
										families.push(cfo);	
										$('#fonts-preload').append('<font style="font-family:\''+cfo+'\'">abcdefghijkl<b>mnopqrx</b><u>tywxz098</u><i>7654321</i></font>');	
										if (
											o.font !== undefined && 
											o.font.indexOf('fonts.gstatic.com') === -1 && 
											(o.font.indexOf('.woff') > -1 || o.font.indexOf('data:') === 0)
										) {
											
											custom.push(cfo);
											
											uco = o.font;
											if (o.font.indexOf('.woff') > -1 && o.font.indexOf('http') === -1)
												uco = customdesign.data.upload_url+o.font;
											
											$('head').append('<style type="text/css">@font-face {font-family:"'+cfo+'";src: url("'+uco+'") format("woff");}</style>');
											
										}else{
	
		 									if (
		 										o.font === undefined || 
		 										o.font.indexOf('fonts.gstatic.com') > -1
		 									)o.font = ["latin","regular"];
		 									
		 									gfonts.push(cfo.replace(/ /g, '+')+':'+o.font[1]);
	 									
	 									}
 									}
								}
								
							});
							
							if (gfonts.length > 0 || custom.length > 0) {
								
								var fload = {
									inactive: function() {
										this.active();
									},
								    active: function () {
									    
										customdesign.f(customdesign.i('importing'));
									    
									    var loo = 0,
											loop_check = function() {
										    var pass = true;
										    loo++;
										    families.map(function(f){
											    if (!document.fonts.check('12px "'+f+'"'))
											    	pass = false;
										    });
										    if (pass === false && loo < 20)
										    	setTimeout(loop_check, 350);
										    else setTimeout(do_import, 100, 0);
									    };
									    
									    loop_check();
									    
								    },
								    text: 'abcdefghijklmnopqrxtywxz0987654321'
								};
								
								if (gfonts.length > 0)
									fload.google = { families: gfonts };
								
								if (custom.length > 0)
									fload.custom = { families: custom };
								
								return WebFont.load(fload);
								
							}else i = 0;
							
						};
						
						if (data.objects[i] !== undefined) {
							
							customdesign.f(customdesign.i('importing'));
							customdesign.ops.importing = true;

							if (data.objects[i] !== null) {

								delete data.objects[i].clipTo;
								delete data.objects[i].active;

								data.objects[i] = $.extend({
									stroke: '',
									strokeWidth: 0,
									scaleX: 1,
									scaleY: 1,
									angle: 0,
									skewX: 0,
									skewY: 0,
									left: stage.limit_zone.left + (stage.limit_zone.width/2),
									top: stage.limit_zone.top + (stage.limit_zone.height/2)
								}, data.objects[i]);
								
								if (customdesign.objects.customdesign[data.objects[i].type]) {

									data.objects[i].top += yCenter;
									data.objects[i].left += xCenter;
 									if (
 										data.objects[i].src !== undefined &&
 										data.objects[i].src.indexOf('http') !== 0 &&
 										data.objects[i].src.indexOf('blob:') !== 0 &&
 										data.objects[i].src.indexOf('data:image/') !== 0
 									) data.objects[i].src = customdesign.data.upload_url+data.objects[i].src;
 								
 									var do_add = function() {
	 									
	 									customdesign.objects.customdesign[data.objects[i].type](
											data.objects[i],
											function (obj) {

												if (obj === null) {
													err = true;
													return do_import(i+1);
												};
												
												canvas.add(obj);

												if (obj.type == 'curvedText')
													obj.set('radius', obj.radius);
												
												if (obj.type =='image' && obj.fx !== undefined) {

											        obj.fxOrigin = obj._originalElement.cloneNode(true);

													setTimeout (function() {

												        customdesign.fn.image_fx(obj.fxOrigin, obj.fx, function(cdata, colors){

															obj._element.src = cdata;
															obj._originalElement.src = cdata;

															obj.colors = colors;

															obj._element.onload = function() {
																customdesign.f(false);
																do_import(i+1);
															}

														});

													}, 1);

										        }else do_import(i+1);

											}
										);
 									};

 									do_add();

								}else do_import(i+1);

							}else do_import(i+1);

						}else{

							canvas.renderAll();
							customdesign.design.layers.build();

							customdesign.ops.importing = false;

							customdesign.f(false);
							
							if (typeof callback == 'function') {
								if (typeof data['template'] !== 'undefined'){
									customdesign.cart.template = data.template.stages;
									customdesign.cart.price.template =  data.template.price;
								};
								
								if (typeof data['extra'] !== 'undefined') 
									customdesign.cart.price.extra =  data.extra;
								
								callback(err);
							}
							
							if (customdesign.fn.url_var('print_download', '') !== '') {
								
								$('li[data-tool="print"]').trigger('click');
								
								$('#customdesign-print-full').prop({checked: true});
								$('#customdesign-print-base').prop({checked: false});
								$('#print-format-'+customdesign.fn.url_var('print_download')).prop({checked: true}).change();
								
								$('#customdesign-print-nav button[data-func="download"]').trigger('click');
								
								customdesign.fn.set_url('print_download', null);
								
							}
							
						}
					},
					err = false;
				
				if (stage.limit_zone === undefined)
					return callback();
					
				xCenter = data.limit_zone !== undefined ? data.limit_zone.left+(data.limit_zone.width/2) : 0,
				yCenter = data.limit_zone !== undefined ? data.limit_zone.top+(data.limit_zone.height/2) : 0;
				
				//limit_zone
				xCenter = xCenter !== 0 ? (stage.limit_zone.left+(stage.limit_zone.width/2)) - xCenter : 0;
				yCenter = yCenter !== 0 ? (stage.limit_zone.top+(stage.limit_zone.height/2)) - yCenter : 0;
				
				customdesign.f(customdesign.i(88));
				
				setTimeout(do_import, 1, -1);
				
			},

			imports : function(data, callback) {
			
				if (!data || !data.stages) {
					return customdesign.fn.notice(customdesign.i(25), 'error');
				};
				
				this.discard();
				
				if (Object.keys(data.stages).length === 1 && Object.keys(data.stages)[0] == 'customdesign') {
					/*
					*	Install template file *.lumi	
					*/
					if (data.clear !== false && localStorage.getItem('CUSTOMDESIGN-TEMPLATE-APPEND') != 'true')
						this.clear();
					
					var cur = customdesign.current_stage;
					
					if (customdesign.data.stages[cur] && data.stages['customdesign'].data) {
						
						if (typeof data.stages['customdesign'].data == 'string')
							customdesign.data.stages[cur].data = JSON.parse(data.stages['customdesign'].data);
						else customdesign.data.stages[cur].data = data.stages['customdesign'].data;
						
						customdesign.data.stages[cur].screenshot = data.stages['customdesign'].screenshot;
						customdesign.data.stages[cur].updated = data.stages['customdesign'].updated;
				    }
				    
				} else {
					
					this.clearAll();
					
					/*
					Object.keys(customdesign.data.stages).map(function(s){
						
						delete customdesign.data.stages[s].data;
						delete customdesign.data.stages[s].screenshot;
						delete customdesign.data.stages[s].updated;
	
						customdesign.data.stages[s].stack = {
							data : [],
						    state : true,
						    index : 0
					    };
	
					});*/
					
					var _stages = {};
					
					Object.keys(data.stages).map(function(s){
						
						if (data.stages[s].data !== '' && typeof data.stages[s].data == 'string')
							data.stages[s].data = JSON.parse(data.stages[s].data);
						
						if (s == customdesign.current_stage) {
							_stages[s] = customdesign.data.stages[s];
							_stages[s].data = data.stages[s].data;
							_stages[s].screenshot = data.stages[s].screenshot;
							_stages[s].updated = data.stages[s].updated;
						} else {
							_stages[s] = data.stages[s];
						    _stages[s].stack = {
								data : [],
							    state : true,
							    index : 0
						    };
						    if (customdesign.data.stages[s] !== undefined) {
						    	_stages[s].src = customdesign.data.stages[s].src;
						    	_stages[s].thumbnail = customdesign.data.stages[s].thumbnail;
						    	_stages[s].source = customdesign.data.stages[s].source;
						    }
						}
						
						if (
							customdesign.data.stages[s] !== undefined &&
							_stages[s].product_width === undefined && 
							customdesign.data.stages[s].product_width !== undefined
						)
					    	_stages[s].product_width = customdesign.data.stages[s].product_width;
					    
					    if (
						    customdesign.data.stages[s] !== undefined &&
							_stages[s].product_height === undefined && 
							customdesign.data.stages[s].product_height !== undefined
						)
					    	_stages[s].product_height = customdesign.data.stages[s].product_height;
					    	
					});
					
					if (data.system_version === undefined) {
						Object.keys(customdesign.data.stages).map(function(s){
							if (_stages[s] === undefined) {
								_stages[s] = customdesign.data.stages[s];
							}
						});
					}
					
					customdesign.data.stages = _stages;

					customdesign.render.stage_nav();
					
				};
				
				var stage = customdesign.data.stages[customdesign.current_stage];
				
				if (stage !== undefined && stage.data !== undefined) {
					
					let scale = 1;
					
					if (stage.data.limit_zone !== undefined)
						scale = stage.limit_zone.width/stage.data.limit_zone.width;		 
					
					if(localStorage.getItem('CUSTOMDESIGN-TEMPLATE-APPEND') == true || localStorage.getItem('CUSTOMDESIGN-TEMPLATE-APPEND') == 'true'){
						scale = 0;
					}

					this.import(customdesign.data.stages[customdesign.current_stage].data, function(){
						
						if (scale !== 1)
							customdesign.fn.scale_designs(scale);
							
						customdesign.stack.save();
						customdesign.fn.update_state();
						
						if (typeof callback == 'function') {
							callback(customdesign.data.stages[customdesign.current_stage]);
						};
						
						delete customdesign.data.color;
						delete customdesign.data.stages[customdesign.current_stage].data;
						
					});
					
				} else {
					customdesign.active_stage(customdesign.render.stage_nav(), callback);
				};
				
				customdesign.fn.navigation('clear');

			},

			discard : function() {

				if (!customdesign.stage())
					return;
				
				var canvas = customdesign.stage().canvas;

				canvas.discardActiveObject();
				canvas.discardActiveGroup();
				canvas.renderAll();

			},

			save : function(e, id, created){
				
				if (customdesign.ops.importing === true)
					return;

				if (customdesign.get.el('main').find('.customdesign-stage').length === 0)
					return;
						
				customdesign.fn.export(e == 'designs' ? 'designs' : true, id/*save to db*/, created);

				customdesign.actions.do('save');

				if (e && typeof e.preventDefault == 'function')
					e.preventDefault();

			},

			load_font : function(family, font, callback) {
				
				var is_returned = false;
				
				if (!document.fonts)
					return;
				
				var ff = family.replace(/[\"\']*/g, '');
				/*
				if (navigator.userAgent.indexOf("Firefox") === -1 && document.fonts.check('1px '+ff)) {

					document.fonts.load('1px '+ff, 'a').then(function(){
						document.fonts.load('italic bold 1px '+ff, 'a').then(function(){
							callback(family);
						});
					});
					return;
				};*/
				
				if (typeof font == 'string') {
					
					if (font.trim().indexOf('http') === -1 && font.trim().indexOf('data:') !== 0)
						font = customdesign.data.upload_url+font;
					else if (font.trim().indexOf('data:text/plain;') > -1)
						font = font.trim().replace('data:text/plain;', 'data:font/truetype;charset=utf-8;');

					if (font.trim().indexOf('url(') !== 0)
						font = 'url('+font+')';
					
					$('head').append('<style type="text/css">@font-face {font-family:"'+ff+'";src: '+font+' format("woff2");}</style>');
					WebFont.load({
						custom: {families: [ff]},
						active: function () {
						    callback(family);
					    }
					});
					return;
				};

				var txt = decodeURIComponent(family).replace(/ /g, '+').replace(/\"/g, '')+':'+font[1]+':'+font[0];
				
				WebFont.load({
				    google: { families: [txt] },
				    active: function () {
					    callback(family);
				    }
				});
			},

			lightbox : function(ops) {

				if (ops == 'close')
					return $('#customdesign-lightbox').remove();

				var cfg = $.extend({
						width: 1000,
						footer: '',
						content: '',
						onload: function(){},
						onclose: function(){}
					}, ops),
					
					tmpl = '<div id="customdesign-lightbox" class="customdesign-lightbox">\
								<div id="customdesign-lightbox-body">\
									<div id="customdesign-lightbox-content" style="min-width:'+cfg.width+'px">\
										'+cfg.content+'\
									</div>\
									'+cfg.footer+'\
									<a class="kalb-close" href="#close" title="Close">\
										<i class="customdesignx-android-close"></i>\
									</a>\
								</div>\
								<div class="kalb-overlay"></div>\
							</div>';

				if (cfg.footer !== '')
					cfg.footer = '<div id="customdesign-lightbox-footer">'+cfg.footer+'</div>';

				tmpl = tmpl.replace(/\%width\%/g, cfg.width).
							replace(/\%content\%/g, cfg.content).
							replace(/\%footer\%/g, cfg.footer);
				
				tmpl = $(tmpl);
				
				$('.customdesign-lightbox').remove();
				$('body').append(tmpl);

				cfg.onload(tmpl);
				tmpl.find('a.kalb-close,div.kalb-overlay').on('click', function(e){
					cfg.onclose(tmpl);
					$('.customdesign-lightbox').remove();
					e.preventDefault();
				});

			},
			
			svg : {
				
				rgb2hex : function(rgb){
					if (rgb === null || rgb === undefined || rgb === '' || rgb.indexOf('#') === 0)
						return rgb;
					rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
					return (rgb && rgb.length === 4) ? "#" +
					("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
					("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
					("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
				},
				
				invertColor : function(hexTripletColor) {
			        var color = hexTripletColor;
			        color = color.substring(1); // remove #
			        color = parseInt(color, 16); // convert to integer
			        color = 0xFFFFFF ^ color; // invert three bytes
			        color = color.toString(16); // convert to hex
			        color = ("000000" + color).slice(-6); // pad with leading zeros
			        color = "#" + color; // prepend #
			        return color;
			    },
				
				getColors : function(svg) {
					
					var fills = [], strokes = [], stops = [];
		
					svg.find('[fill]').map(function () {
						if (this.getAttribute('fill').indexOf('rgb') > -1)
							this.setAttribute('fill', customdesign.tools.svg.rgb2hex(this.getAttribute('fill')));
						this.setAttribute('data-fill-attr-color', this.getAttribute('fill'));
						fills.push(this.getAttribute('fill'));
					});
					
					svg.find('[stroke]').each(function () {
						this.setAttribute('data-stroke-attr-color', this.getAttribute('stroke'));
						strokes.push(this.getAttribute('stroke'));
					});
					
					svg.find('[stop-color]').map(function () {
						this.setAttribute('data-stop-attr-color', this.getAttribute('stop-color'));
						stops.push(this.getAttribute('stop-color'));
					});
					
					svg.find('[style]').each(function () {
						
						if (this.style.fill && this.style.fill !== '') {
							fills.push(this.style.fill);
							this.setAttribute('data-fill-style-color', this.style.fill);
						};
						
						if (this.style.stroke && this.style.stroke !== '') {
							strokes.push(this.style.stroke);
							this.setAttribute('data-stroke-style-color', this.style.stroke);
						};
						
						if (this.style.stopColor && this.style.stopColor !== '') {
							stops.push(this.style.stopColor);
							this.setAttribute('data-stop-style-color', this.style.stopColor);
						};
						
					});
					
					var colors = {};
					
					for (var i=0; i<fills.length; i++) {
						if (fills[i].indexOf('url') === -1 && fills[i] != 'none') {
							if (colors[fills[i]] === undefined)
								colors[fills[i]] = 1;
							else colors[fills[i]]++;
						}
					}
					
					for (var i=0; i<strokes.length; i++) {
						if (strokes[i].indexOf('url') === -1 && strokes[i] != 'none') {
							if (colors[strokes[i]] === undefined)
								colors[strokes[i]] = 1;
							else colors[strokes[i]]++;
						}
					}
					
					for (var i=0; i<stops.length; i++) {
						if (stops[i].indexOf('url') === -1 && stops[i] != 'none') {
							if (colors[stops[i]] === undefined)
								colors[stops[i]] = 1;
							else colors[stops[i]]++;
						}
					}
					
					return Object.keys(colors).sort(function(a, b) {
				        return (colors[a] < colors[b]) ? 1 : ((colors[a] > colors[b]) ? -1 : 0);
				    });
					
				},
				
				renderColors : function(el) {
		
					var _this = this,
						colors = this.getColors($('#customdesign-svg-edit>svg')),
						inps = $('#customdesign-svg-tool div[data-view="current-colors"]');
					
					inps.html('');
					
					colors.map(function(color){
						inps.append('<span><input type="color" data-color="'+color+'" value="'+_this.rgb2hex(color)+'" style="background-color:'+color+';color: '+color+'" /></span>');
					});
					
					inps.find('input[type="color"]').on('input', function(e) {
						
						var color = this.getAttribute('data-color'),
							new_color = this.value,
							svg = $('#customdesign-svg-edit svg');
						
						svg.find('[fill][data-fill-attr-color="'+color+'"]').attr({fill: new_color});
						svg.find('[fill][data-stroke-attr-color="'+color+'"]').attr({stroke: new_color});
						svg.find('[fill][data-stop-attr-color="'+color+'"]').attr({'stop-color': new_color});
						
						svg.find('[data-fill-style-color="'+color+'"]').css({fill: new_color});
						svg.find('[data-stroke-style-color="'+color+'"]').css({stroke: new_color});
						svg.find('[data-stop-style-color="'+color+'"]').css({stopColor: new_color});
						
					});
					
					if (el !== undefined)
						this.render_fills(el);
				
				},
				
				render_fills : function(e_l) {
					
					var _this = this,
						fill = e_l.getAttribute('fill') ? e_l.getAttribute('fill') : 
							   e_l.style.fill.replace(/\ /g, '').replace(/\"/g, ''),
						stroke = e_l.getAttribute('stroke') ? e_l.getAttribute('stroke') : 
							   e_l.style.stroke.replace(/\ /g, '').replace(/\"/g, ''),
						stroke_width = e_l.getAttribute('stroke-width') ? e_l.getAttribute('stroke-width') : 
							   e_l.style.strokeWidth.replace(/\ /g, '').replace(/\"/g, ''),
						inps = $('#customdesign-svg-fills-custom'),
						inpz = $('#customdesign-svg-strokes-custom'),
						el = $(e_l);
						
					inps.html('');
					
					if (fill.indexOf('url') > -1) {
						
						var linear = $(fill.replace('url(', '').replace(')', ''));
						
						linear.find('stop').each(function(i) {
							inps.append('<span><input type="color" value="'+_this.rgb2hex(this.style.stopColor)+'" data-i="'+i+'" /><small data-i="'+i+'" title="Delete">x</small></span>');
						});
						inps.find('input').on('input', function(e) {
							linear.find('stop').eq(this.getAttribute('data-i')).css({stopColor: this.value});
							_this.renderColors();
						});
						inps.find('small[data-i]').on('click', function(e) {
							linear.find('stop').eq(this.getAttribute('data-i')).remove();
							$(this).parent().remove();
							_this.renderColors(e_l);
						});
					}else if (fill !== ''){
						inps.append('<span><input type="color" value="'+(fill.indexOf('rgb') > -1 ? _this.rgb2hex(fill) : fill)+'" /><small data-i="0" title="Delete">x</small></span>');
						inps.find('input').on('input', function(e) {
							el.css({'fill': this.value});
							el.removeAttr('fill');
							_this.renderColors();
						});
						inps.find('small[data-i]').on('click', function(e) {
							el.css({'fill': ''});
							el.removeAttr('fill');
							$(this).parent().remove();
							_this.renderColors(e_l);
						});
					}else{
						var a = $('<a href="#">Add fill color</a>');
						inps.html('').append(a);
						a.on('click', function(e){
							el.css({'fill': '#4ca722'});
							_this.renderColors(e_l);
							e.preventDefault();
						});
					};
					
					if (stroke !== ''){
						inpz.html('<input type="color" value="'+(stroke.indexOf('rgb') > -1 ? _this.rgb2hex(stroke) : stroke)+'" /><input placeholder="Stroke width" type="range" min="0" max="50" value="'+parseFloat(stroke_width)+'" /><p><a href="#">Remove stroke</a></p>');
						inpz.find('input').on('input', function(e) {
							
							if (this.type === 'color')
								el.css({'stroke': this.value});
							else el.css({'stroke-width': this.value});
							_this.renderColors();
						});
						inpz.find('a').on('click', function(e){
							el.css({'stroke': '', 'stroke-width': ''});
							_this.renderColors(e_l);
							e.preventDefault();
						});
					}else{
						var a = $('<a href="#">Add stroke</a>');
						inpz.html('').append(a);
						a.on('click', function(e){
							el.css({'stroke': '#4ca722', 'stroke-width': '1px'});
							_this.renderColors(e_l);
							e.preventDefault();
						});
					}
					
				},
				
				replace : function(svg, new_color, color) {
					
					if (svg === undefined) {
						$('#customdesign-color-picker-header i').click();
						return;	
					};
					
					svg.find('[fill][data-fill-attr-color="'+color+'"]').attr({fill: new_color});
					svg.find('[fill][data-stroke-attr-color="'+color+'"]').attr({stroke: new_color});
					svg.find('[fill][data-stop-attr-color="'+color+'"]').attr({'stop-color': new_color});
					
					svg.find('[data-fill-style-color="'+color+'"]').css({fill: new_color});
					svg.find('[data-stroke-style-color="'+color+'"]').css({stroke: new_color});
					svg.find('[data-stop-style-color="'+color+'"]').css({stopColor: new_color});
					
				},
				
				edit : function() {
					
					var _this = this,
						canvas = customdesign.stage().canvas,
						active = canvas.getActiveObject(),
						svg = atob(active.src.split('base64,')[1]);
						
					$('#CustomdesignDesign').append(
						'<div id="customdesign-svg-workspace">\
							<div id="customdesign-svg-edit">'+
								svg.substr(svg.indexOf('<svg'))+'\
							</div>\
							<div data-view="zoom">\
								<i class="customdesignx-android-search"></i> zoom <input type="range" min="100" max="300" value="100" />\
							</div>\
							<div id="customdesign-svg-tool">\
								<ul data-view="nav">\
									<li data-func="save" title="'+customdesign.i('save')+'"><i class="customdesignx-android-done"></i></li>\
									<li data-func="reset" title="'+customdesign.i('reset')+'"><i class="customdesignx-android-refresh"></i></li>\
									<li data-func="cancel" title="'+customdesign.i('cancel')+'"><i class="customdesignx-android-close"></i></li>\
								</ul>\
								<h3>All colors</h3>\
								<div data-view="current-colors"></div>\
							</div>\
						</div>'
					);
					
					var svg = $('#customdesign-svg-edit>svg');
					
					if (svg.attr('width')) {
						svg.attr('data-width', svg.attr('width'));
						svg.removeAttr('width');
					};
					
					if (svg.attr('height')) {
						svg.attr('data-height', svg.attr('height'));
						svg.removeAttr('height');
					};
					
					var w = svg.width(),
						h = svg.height();
						
					svg.on('click', function(e) {
				
						var allw = ['a', 'audio', 'canvas', 'circle', 'ellipse', 'foreignObject', 'g', 'iframe', 'image', 'line', 'mesh', 'path', 'polygon', 'polyline', 'rect', 'svg', 'switch', 'symbol', 'text', 'textPath', 'tspan', 'unknown', 'use', 'video'];
		
						if (allw.indexOf(e.target.tagName.toLowerCase()) > -1) {
							
							if ($('#customdesign-svg-tool div[data-view="customize"]').length === 0) {
								$('#customdesign-svg-tool>ul[data-view="nav"]').
									after(
										'<h3>Selection</h3>\
										<div data-view="customize">\
											<label>Fill:</label>\
											<div class="lumst" id="customdesign-svg-fills">\
												<div id="customdesign-svg-fills-custom"></div>\
											</div>\
										</div>\
										<div data-view="customize">\
											<label>Stroke:</label>\
											<div class="lumst" id="customdesign-svg-strokes">\
												<div id="customdesign-svg-strokes-custom"></div>\
											</div>\
										</div>'
									);
							}
							
							_this.render_fills(e.target);
							
						}
					});
					
					$('#customdesign-svg-workspace input[type="range"]').on('input', function(){
						svg.css({
							'width': (w*(this.value/100))+'px', 
							'max-width': (w*(this.value/100))+'px', 
							'height': (h*(this.value/100))+'px',
							'max-height': (h*(this.value/100))+'px'
						});
					});
					
					$('#customdesign-svg-tool ul li').on('click', function(e) {
						switch (this.getAttribute('data-func')) {
							case 'save' : 
							
								svg.removeAttr('style');
								svg.attr({width: svg.data('width'), height: svg.data('height')});
								svg.removeAttr('data-width');
								svg.removeAttr('data-height');
								
								var canvas = customdesign.stage().canvas,
									active = canvas.getActiveObject(),
									colors = _this.getColors(svg),
									svg_html = svg.parent().html(),
									src = 'data:image/svg+xml;base64,'+btoa(svg_html);
								
								$('#customdesign-svg-workspace').remove();
									
								if (active === undefined || active === null)
									return;
									
								active.set('fill', '');
								active.set('src', src);
								active.set('origin_src', src);
								delete active.j_object;
								active.colors = colors;
								active._element.src = src;
								active._originalElement.src = src;
								active._element.onload = function(){
									canvas.renderAll();	
									customdesign.fn.set_svg_colors(active);
								};
								
							break;
							case 'reset' : 
								$('#customdesign-svg-workspace').remove();
								customdesign.tools.svg.edit();
							break;
							case 'cancel' : 
								$('#customdesign-svg-workspace').remove();
							break;
						}
					});
					
					this.renderColors();
					
				}
				
			}

		},

		stack : {
			
			working : false,
			
		    save : function() {
				
				if (customdesign.ops.importing === true || customdesign.stack.working === true)
					return;

			    var stage = customdesign.stage(),
			    	stack = stage.stack,
			    	canvas = stage.canvas,
			    	hash = '',
			    	apply = false;

				canvas.getObjects().map(function(obj){
					if (obj.evented === true) {
						
						if (typeof obj.clipTo != 'function') {
							obj.set('clipTo', function(ctx){
								return customdesign.objects.clipto(ctx, obj);
							});
							apply = true;
						};
						hash += obj.id+':'+
								(obj.src !== undefined ? obj.src.length : '')+
								(obj.fill !== undefined ? obj.fill : '')+
								(obj.stroke !== undefined ? obj.stroke : '')+
								(obj.text !== undefined ? obj.text : '')+
								(obj.font !== undefined ? obj.font : '')+
								(obj.fx !== undefined ? JSON.stringify(obj.fx).length : '')+
								obj.scaleX.toString()+
								obj.scaleY.toString()+
								obj.width.toString()+
								obj.height.toString()+
								obj.left.toString()+
								obj.top.toString();
					}
				});
				
				if (
					(
						stack.data[stack.index] !== undefined && 
						hash == stack.data[stack.index].hash
					) || hash === ''
				) return;
				
				if (apply) {
					canvas.renderAll();
					customdesign.design.layers.build();
				}
				
				if (stack.data.length > 50)
					stack.data = stack.data.splice(stack.data.length-50);

				var current = customdesign.tools.export(customdesign.stage());
				
				current['template'] = {
					stages : customdesign.cart.template,
					price : customdesign.cart.price.template
				};
				current = JSON.stringify(current);

				stack.data.splice(stack.index+1);

				stack.data.push({hash: hash, data: current});
				stack.index = stack.data.length - 1;

				customdesign.get.el('design-redo').addClass("disabled");
				
				if (stack.data.length > 1)
					customdesign.get.el('design-undo').removeClass("disabled");
				
                customdesign.actions.do('stack:save:complete');
				
				if (stack.data.length > 1) {
					customdesign.tools.save();
				}else{
					customdesign.ops.before_unload = null;
				}
		    },

		    back : function(e) {

			    var stack = customdesign.stage().stack,
			    	canvas = customdesign.stage().canvas;

				if (stack.index > 0) {
					stack.state = false;
					var current = JSON.parse(stack.data[stack.index - 1].data);
					customdesign.tools.clear();
					customdesign.stack.working = true;
					customdesign.tools.import(current, function (){
						customdesign.fn.update_state();
						customdesign.stack.working = false;
					});
					
					stack.index--;
					customdesign.get.el('design-redo').removeClass("disabled");
				}

				if (stack.index === 0){
					customdesign.get.el('design-undo').addClass("disabled");
				}

				if (e)e.preventDefault();

		    },

		    forward : function(e) {

			    var stack = customdesign.stage().stack,
			    	canvas = customdesign.stage().canvas;

				if (stack.data[stack.index + 1]) {
					stack.state = false;
					var current = JSON.parse(stack.data[stack.index + 1].data);
					customdesign.tools.clear();
					customdesign.stack.working = true;
					customdesign.tools.import(current, function (){
						customdesign.fn.update_state();
						customdesign.stack.working = false;
					});
					stack.index++;
					customdesign.get.el('design-undo').removeClass("disabled");
				}

				if (!stack.data[stack.index + 1]) {
					customdesign.get.el('design-redo').addClass("disabled");
				}

				if (e)e.preventDefault();

		    }

		},

		get : {

			els : {},

			color : function(s){

				var color = $('.customdesign-cart-field[data-type="product_color"]').find('li[data-color].choosed').attr('data-color');
				
				if (!color)
					color = customdesign.data.color ? customdesign.data.color : '#dedede';
				else color = decodeURIComponent(color);
				
				return (s != 'invert' ? color : customdesign.fn.invert(color));

			},
			
			color_name : function(s){

				var elm = customdesign.get.el('product-color').find('li[data-color].choosed');
				return ( !elm.get(0) )? '': elm.attr('title');
				
			},

			scroll : function() {
				return {
					top: (customdesign.body.scrollTop?customdesign.body.scrollTop:customdesign.html.scrollTop),
					left: (customdesign.body.scrollLeft?customdesign.body.scrollLeft:customdesign.html.scrollLeft)
				}
			},

			active : function() {
				return customdesign.stage().canvas.getActiveObject() || customdesign.stage().canvas.getActiveGroup();
			},

			stage : function() {
				return {
					stage: customdesign.stage(),
					canvas: customdesign.stage().canvas,
					active: customdesign.stage().canvas.getActiveObject(),
					limit: customdesign.stage().limit_zone
				}
			},
			
			size : function() {
				
				var stage = customdesign.stage(),
					size = customdesign.get.el('print-nav').find('input[name="size"]').val().split('x'),
					unit = $('#customdesign-print-nav input[name="print-unit"]:checked').data('unit'),
					o = customdesign.get.el('print-nav').find('select[name="orientation"]').val(),
					w = parseFloat(size[0].trim()),
					h = parseFloat(size[1] ? size[1].trim() : 0);
				
				if (stage.size === undefined || stage.size === '') {
					
					if (unit == 'inch') {
						w *= 2.54*118.095238;
						h *= 2.54*118.095238;
					} else if (unit == 'cm') {
						w *= 118.095238;
						h *= 118.095238;
					};
					
					if (size[0] === '' || size[1] === undefined || size[1] === '') {
						customdesign.get.el('print-nav').find('input[name="size"]').focus();
						return alert(customdesign.i(35));
					};
					
				} else if (typeof stage.size == 'string') {
					
					Object.keys(customdesign.data.size_default).map(function(s) {
						if (customdesign.data.size_default[s].cm == stage.size) {
							size = customdesign.data.size_default[s].px.split('x');
						}
					});
					
					w = parseFloat(size[0].trim()),
					h = parseFloat(size[1] ? size[1].trim() : 0);
					
				} else if (typeof stage.size == 'object') {
					
					w = parseFloat(stage.size.width);
					h = parseFloat(stage.size.height);
					
					if (stage.size.unit == 'inch') {
						w *= 2.54*118.095238;
						h *= 2.54*118.095238;
					} else if (stage.size.unit == 'cm') {
						w *= 118.095238;
						h *= 118.095238;
					};
				};
				
				return {
					o: o,
					w: w,
					h: h
				};
					
			},
			
			el : function(s) {
				
				if (!customdesign.get.els[s]) {
					if ($('#customdesign-'+s).length > 0)
						customdesign.get.els[s] = $('#customdesign-'+s);
					else return $('#customdesign-'+s);
				}

				return customdesign.get.els[s];

			},

		},

		fn : {
			
			version_compare : function(a, b) {
				
				if (a === undefined || b === undefined)
					return 0;
					
			    var pa = a.split('.');
			    var pb = b.split('.');
			    
			    for ( var i = 0; i < 3; i++ ) {
				    
			        var na = Number(pa[i]);
			        var nb = Number(pb[i]);
			        
			        if (na > nb) 
			        	return 1;
			        
			        if (nb > na) 
			        	return -1;
			        
			        if (!isNaN(na) && isNaN(nb)) 
			        	return 1;
			        
			        if (isNaN(na) && !isNaN(nb)) 
			        	return -1;
			    }
			    
			    return 0;
			    
			},
			
			invert : function(color) {

				var r,g,b;

				if (color.indexOf('rgb') > -1) {

					color = color.split(',');
					r = parseInt(color[0].trim());
					g = parseInt(color[1].trim());
					b = parseInt(color[2].trim());

				} else {
					if (color.length < 6)
						color += color.replace('#', '');
					var cut = (color.charAt(0)=="#" ? color.substring(1,7) : color.substring(0,6));
					r = (parseInt(cut.substring(0,2),16)/255)*0.213;
					g = (parseInt(cut.substring(2,4),16)/255)*0.715;
					b = (parseInt(cut.substring(4,6),16)/255)*0.072;
				}

				return (r+g+b < 0.5) ? '#DDD' : '#333';
			},

			reversePortView : function(eff){
				
				 
				var m = customdesign.get.el('stage-'+customdesign.current_stage).get(0);
				
				if (m === undefined)
					return;
					
				var stage = customdesign.stage(),
					canvas = stage.canvas,
					view = canvas.viewportTransform,
					ratio = customdesign.get.el('zoom').val()/100,
					wr = ((m.offsetWidth*ratio)/100),
					hr = ((m.offsetHeight*ratio)/100),
					p = {
						w: (stage.product.width*ratio),
						h: (stage.product.height*ratio),
						l: (stage.product.left-(stage.product.width/2))*ratio,
						t: (stage.product.top-(stage.product.height/2))*ratio,
					},
					w = {
						w: m.offsetWidth,
						h: m.offsetHeight
					},
					_rw = p.w/w.w > 1 ? p.w/w.w : 1,
					_rh = p.h/w.h > 1 ? p.h/w.h : 1;

		        var anicfg = {
			        x: view[4] > 0 ? 0 : ((view[4] > -p.l && p.w > w.w) ? 0 : (
			        	view[4] < -(canvas.width*view[0] - canvas.width) ?
			        	-(canvas.width*view[0] - canvas.width) :
			        	view[4])
			        ),
			        y: view[5] > 0 ? 0 : ((view[5] > -p.t && p.h > w.h) ? 0 : (
			        	view[5] < -(canvas.height*view[0] - canvas.height) ?
			        	-(canvas.height*view[0] - canvas.height) :
			        	view[5])
			        )
			    };

			    /*anicfg.x = -((canvas.width*view[0])-canvas.width)/2;*/
				/*
				if (view[0] > 1) {
					anicfg.x = (
						((canvas.width/2)/view[0])+(stage.limit_zone.left/view[0]) -
						((canvas.width/2)+stage.limit_zone.left)
					);
				} else {
					anicfg.x = 0;
					anicfg.y = 0;
				};*/

			    if (anicfg.x == view[4] && anicfg.y == view[5])
			    	return true;

		        if (eff === false) {
					//view[4] = anicfg.x;
					view[5] = anicfg.y;
					canvas.set('viewportTransform', view);
					canvas.renderAll();
				}

				return false;

			},

			onZoomThumnMove : function(e) {

		        var ratio = customdesign.get.el('zoom').val()/100,
					m = customdesign.get.el('main').get(0),
		        	delta = new fabric.Point(-e.movementX*((m.offsetWidth*ratio)/100), -e.movementY*((m.offsetHeight*ratio)/100));

				customdesign.stage().canvas.relativePan(delta);
				customdesign.fn.reversePortView(false);

			},

			notice : function(content, type, delay) {

				var i = 'bulb';
				switch (type) {
					case 'success': i = 'done'; break;
					case 'error': i = 'close'; break;
				};

				var el = customdesign.get.el('notices');
				clearTimeout(customdesign.ops.notice_timer);

				if (el.data('working')) {
					el.stop()
					.append('<span data-type="'+type+'"><i class="customdesignx-android-'+i+'"></i> '+content+'</span>')
					.animate({opacity: 1, top: 55}, 250);
				}else{
					el.data({'working': true}).stop()
					.html('<span data-type="'+type+'"><i class="customdesignx-android-'+i+'"></i> '+content+'</span>')
					.css({opacity: 0, top: 0, display: 'block'})
					.animate({opacity: 1, top: 55}, 250);
				}

				customdesign.ops.notice_timer = setTimeout(function(){
					el.animate({top: 0, opacity: 0}, 250, function(){
						this.style.display = 'none';
						el.data({'working': false});
					});
				},(delay ? delay : 1500), el);

			},

			bridgeText : function(image, ops) {

				if (!ops)
					ops = {
						curve: -2.5,
						offsetY: 0.4,
						bottom: 2.5,
						trident: false,
						oblique: false
					};
				
			    var s = customdesign.get.stage(),
			    	w = image.width,
			    	h = image.height*2.5,

				    curve = ops.curve !== undefined ? (ops.curve/2)*image.height : -0.3*image.height,
				    top = ops.offsetY !== undefined ? ops.offsetY*image.height : 0.5*image.height,
				    bottom = ops.bottom !== undefined ? ops.bottom*image.height : 0.2*image.height,
				    trident = ops.trident !== undefined ? ops.trident: false,
				    d, i = w, y = 0, angle = (ops.oblique === true ? 45 : 180) / w;

				if (ops.oblique === true)
					trident = false;

				if (customdesign.ops.brid === undefined) {
					customdesign.ops.brid = document.createElement('canvas');
					customdesign.ops.bctx = customdesign.ops.brid.getContext('2d');
				}

				customdesign.ops.brid.width = w;
				customdesign.ops.brid.height = h;

			    customdesign.ops.bctx.clearRect(0, 0, w, h);

			    if (trident) {
			    	y = bottom;
			    	d = (curve) / (h*0.25);
			    	if ((d*w*0.5) > bottom) {
					    d = bottom/(w*0.5);
				    }
			    }else if (ops.oblique){
				    if (curve > bottom+(h*0.25))
			   		 	curve = bottom+(h*0.25);
			    }else{
				    if (curve > bottom)
			   		 	curve = bottom;
			    }

			    while (i-- > 0) {

			        if (trident) {

			            if (i >(w * 0.5))
			            	 y -= d;
						else y += d;

			        } else {
			            y = bottom - curve * Math.sin(i * angle * Math.PI / 180);
			        }

			        customdesign.ops.bctx.drawImage(
			        	image,
			        	i, 0, 1, h,
			            i, h * 0.5 - top / h * y, 1, y
			        );
			    }

				return customdesign.ops.brid.toDataURL();

			},

			update_text_fx : function() {
				
				var s = customdesign.get.stage();

				if (!s.active)
					return;

				customdesign.f('Processing..');

				var props = s.active.toObject(customdesign.ops.export_list);
				delete props['type'];
				var newobj = customdesign.objects.text(props);
				props.width = newobj.width;
				props.height = newobj.height;

				customdesign.objects.customdesign['text-fx'](props, customdesign.fn.switch_type);

			},

			image_fx : function(img, fx, callback){
				
				if (!img) 
					return false;
				
				if (
					fx &&
					fx.mask &&
					fx.mask.dataURL &&
					(fx.mask.image === undefined || fx.mask.image.src === undefined)
				) {
					
					fx.mask.image = new Image();
					fx.mask.image.onload = function(){
						customdesign.fn.image_fx(img, fx, callback);
					};

					if (
						fx.mask.dataURL.indexOf('http') !== 0 &&
						fx.mask.dataURL.indexOf('data:image/') !== 0
					)fx.mask.dataURL = customdesign.data.upload_url+fx.mask.dataURL;

					return fx.mask.image.src = fx.mask.dataURL;
				}

				var cfg = $.extend({
					fx: '',
					brightness: 0,
					saturation: 100,
					contrast: 0,
					deep: 0,
					mode: 'light',
					mask: null
				}, fx);

				if (cfg.brightness !== 0)
					cfg.brightness /= 2;

				if (!customdesign.ops.imageFXcanvas) {
					customdesign.ops.imageFXcanvas = document.createElement('canvas');
					customdesign.ops.fxctx = customdesign.ops.imageFXcanvas.getContext("2d");
				};

				var cv = customdesign.ops.imageFXcanvas,
					ctx = customdesign.ops.fxctx,
					w = img.width,
					h = img.height;

				cv.width = w;
				cv.height = h;

				ctx.clearRect(0, 0, w, h);

				if (cfg.mask !== null && cfg.mask.image) {
					ctx.drawImage(cfg.mask.image, cfg.mask.left*w, cfg.mask.top*h, cfg.mask.width*w, cfg.mask.height*h);
					ctx.globalCompositeOperation = 'source-in';
				};
				
				ctx.drawImage(img, 0, 0, w, h);

				if (fx && fx.crop) {
					ctx.clearRect(0, 0, w, h*fx.crop.top);
					ctx.clearRect(0, 0, w*fx.crop.left, h);
					ctx.clearRect((w*fx.crop.left)+(w*fx.crop.width), 0, w, h);
					ctx.clearRect(0, (h*fx.crop.top)+(h*fx.crop.height), w, h);
				};

				var imageData = ctx.getImageData(0, 0, w, h);
				var data = imageData.data;

				if (cfg.fx !== '' && customdesign_fx_map[cfg.fx])
					cfg.fx = customdesign_fx_map[cfg.fx]();

				var R, G, B, CT, brightness;

				var rfx, gfx, bfx;

				var vgrid = 0;

				for (var i = 0; i < data.length; i += 4) {

					if (typeof cfg.fx == 'object') {

						data[i] = cfg.fx.r[ data[i] ];
						data[i+1] = cfg.fx.g[ data[i+1] ];
						data[i+2] = cfg.fx.b[ data[i+2] ];

					};

					brightness = (0.4 * (data[i] + cfg.brightness)) + (0.4 * (data[i+1] + cfg.brightness)) + (0.2 * (data[i+2] + cfg.brightness));

					brightness *= ( 1 - cfg.saturation/100 );

					R = brightness + data[i]*( cfg.saturation/100 ) + cfg.brightness;
					G = brightness + data[i+1]*( cfg.saturation/100 ) + cfg.brightness;
					B = brightness + data[i+2]*( cfg.saturation/100 ) + cfg.brightness;

					if( cfg.contrast != 0 ) {

						CT = 1 + (cfg.contrast*0.01);
						R /= 255;
						G /= 255;
						B /= 255;

						R = (((R - 0.5) * CT) + 0.5) * 255;
						G = (((G - 0.5) * CT) + 0.5) * 255;
						B = (((B - 0.5) * CT) + 0.5) * 255;

						R = R > 255 ? 255 : R;
						R = R < 0 ? 0 : R;

						G = G > 255 ? 255 : G;
						G = G < 0 ? 0 : G;

						B = B > 255 ? 255 : B;
						B = B < 0 ? 0 : B;

					};

					data[i] = R;
					data[i+1] = G;
					data[i+2] = B;

					if (cfg.deep > 0) {

						if (cfg.mode != 'dark') {
							if (255-R < cfg.deep && 255-G < cfg.deep && 255-B < cfg.deep) {
								data[i+3] = ((((255-R)/cfg.deep) + ((255-G)/cfg.deep) + ((255-B)/cfg.deep))/3);
								data[i+3] = (data[i+3]>0 ? data[i+3]*100 : 0);
							}
						}else{
							if (R < cfg.deep && G < cfg.deep && B < cfg.deep) {
								data[i+3] = (((R/cfg.deep) + (G/cfg.deep) + (B/cfg.deep))/3);
								data[i+3] = (data[i+3]>0 ? data[i+3]*100 : 0);
							}
						}
					}

				};

				ctx.putImageData( imageData, 0 , 0 );
				return callback(cv.toDataURL(), customdesign.fn.count_colors(cv, true));

			},

			update_image_fx : function(fx, val, callback) {

				var s = customdesign.get.stage();
				
				if (!s.active)
					return;

				customdesign.f('Processing..');
				
				clearTimeout(customdesign.ops.update_image_fx_timer);
				
				customdesign.ops.update_image_fx_timer = setTimeout(function(){
					
					var next_step = function() {
						if (s.active.fx === undefined || s.active.fx === null)
							s.active.fx = {};
						
						if (fx !== undefined)
							s.active.fx[fx] = val;
						 
						if(!s.active.fxOrigin) {
							s.active.fxOrigin = new Image();
							s.active.fxOrigin.src = (
								s.active.full_src !== undefined && s.active.full_src !== ''
							) ? s.active.full_src : s.active.src;
							s.active.fxOrigin.onload = next_step;
						};
						
						customdesign.fn.image_fx(s.active.fxOrigin, s.active.fx, function(cdata, colors){
	
							s.active._element.src = cdata;
							s.active._originalElement.src = cdata;
							s.active.colors = colors;
	
							s.active._element.onload = function() {
								s.canvas.renderAll();
								customdesign.f(false);
								if (typeof callback == 'function')
									callback();
							}
	
						});
					};
					
					if (!s.active.fxOrigin || !s.active.fxOrigin.tagName) {
						if (s.active.full_src) {
							s.active.fxOrigin = new Image();
							s.active.fxOrigin.src = (
								s.active.full_src !== undefined && s.active.full_src !== ''
							) ? s.active.full_src : s.active.src;
							s.active.fxOrigin.onload = next_step;
							return;
						};
						s.active._originalElement.cloneNode(true);
					};
					
					next_step();
					
				}, 1);

			},
			
			refresh_image_fx : function(active, callback) {

				if (typeof callback != 'function')
					callback = function() {};
					
				if (
					!active ||
					active.fx === undefined || 
					active.fx === null ||
					Object.keys(active.fx).length === 0
				) return callback();
					
				customdesign.f('Processing FX..');
				
				clearTimeout(customdesign.ops.update_image_fx_timer);
				
				customdesign.ops.update_image_fx_timer = setTimeout(function(){
					
					if (!active.fxOrigin || !active.fxOrigin.tagName)
						active.fxOrigin = active._originalElement.cloneNode(true);
					
					customdesign.fn.image_fx(active.fxOrigin, active.fx, function(cdata, colors){

						active._element.src = cdata;
						active._originalElement.src = cdata;
						active.colors = colors;

						active._element.onload = function() {
							customdesign.stage().canvas.renderAll();
							customdesign.f(false);
							callback();
						}

					});

				}, 1);

			},

			fill_svg : function(data, color) {
				
				if (data.toString().indexOf('data:image/svg+xml;base64,') === -1)
					return data;

				var svg = atob(data.split(',')[1]),
					span = $('<span>'+svg.substr(svg.indexOf('<svg'))+'</span>');
				
				if (color && color !== '')
					span.find('svg,path').attr({'fill': color});
					
				svg = 'data:image/svg+xml;base64,'+btoa(span.html());
				delete span;

				return svg;

			},
			
			product_color : function(color) {
				
				if (color === undefined || color === '')
					color = '#dedede';
				
				var stage = customdesign.stage();
					
				if (stage.limit_zone) {
					
					var invert = customdesign.fn.invert(color);
					stage.limit_zone.set('stroke', invert);
					
					stage.productColor.set('fill', color);
					stage.canvas.renderAll();
					
					Object.keys(customdesign.data.stages).map(function(s){
						if (s != customdesign.current_stage && customdesign.data.stages[s].canvas !== undefined) {
							customdesign.data.stages[s].productColor.set('fill', color);
							customdesign.data.stages[s].canvas.renderAll();
						}	
					});
					
					customdesign.tools.save();
					
				}
				
				customdesign.actions.do('product-color', color);
				
			},
					
			set_svg_colors : function(obj) {
				
				if (obj.j_object === undefined) {
					var svg_source = obj.src.split('base64,')[1];
					svg_source = atob(svg_source);
					svg_source = svg_source.substr(svg_source.indexOf('<svg'));
					obj.j_object = $('<div>'+svg_source+'</div>');
				};
				
				var max = (customdesign.get.el('svg-colors').parent().width()-180)/33,
					colors = customdesign.tools.svg.getColors(obj.j_object),
					total = colors.length;
				
				if (max < 6)
					max = 6;
				else if (max > 15)
					max = 15;
				
				if (total === 0) {
					obj.j_object.find('svg>*').css({fill: '#000000'});
					colors = customdesign.tools.svg.getColors(obj.j_object);
				};
				
				obj.colors = colors.slice();
				colors.splice(max);
				
				customdesign.get.el('svg-colors').find('>span').remove();
				
				colors.map(function(c){
					customdesign.get.el('svg-colors').append(
						'<span data-view="noicon" data-color="'+c+'"><input type="text" data-color="'+c+'" readonly value="" style="background:'+c+'" /></span>'
					);
				});
				
				if (total > colors.length) {
					customdesign.get.el('svg-colors').append('<span data-view="more">+'+(total-colors.length)+'</span>');
				};
				
				customdesign.get.el('svg-colors').append('<span data-view="btn" data-tip="true"><i class="customdesignx-wand" data-func="editor"></i><span>'+customdesign.i(138)+'</span></span>');
					
			},
			
			switch_type : function(newobj) {

				var s = customdesign.get.stage();

				if (newobj !== null) {
					customdesign.ops.importing = true;
					var index = s.canvas.getObjects().indexOf(s.active);
					s.canvas.remove(s.active);
					s.canvas.add(newobj);
					newobj.moveTo(index);
					s.canvas.setActiveObject(newobj).renderAll();
					customdesign.get.el('top-tools').attr({'data-view': newobj.type});
					customdesign.design.layers.build();
					customdesign.ops.importing = false;
				}else alert(customdesign.i(19));

				customdesign.f(false);

			},
			
			download_design : function (ops) {
				
				var type = ops.type,
					include_base = ops.include_base,
					stage =  customdesign.stage(),
					canvas = stage.canvas,
					wcf = "menubar=0,status=0,titlebar=0,toolbar=0,location=0,directories=0",
					ex = {
					    format: 'png',
					    multiplier: 2/**(2/window.devicePixelRatio)*/,
					    width: stage.product.width,
					    height: stage.product.height,
					    top: stage.product.top-(stage.product.height/2),
					    left: stage.product.left-(stage.product.width/2)
					},
					name = customdesign.data.prefix_file+'_'+customdesign.fn.slugify(
						$('#customdesign-product header name t').text()
					)+'_'+customdesign.current_stage;
				
				if (customdesign.fn.url_var('order_print', '') !== '') {
					name = 'order-'+customdesign.fn.url_var('order_print')+'__product-'+customdesign.fn.url_var('product_cms')+'__base-'+customdesign.fn.url_var('product_base')+'__stage-'+(Object.keys(customdesign.data.stages).indexOf(customdesign.current_stage)+1);
				}
				
				customdesign.get.el('zoom').val(100).trigger('input');

				switch (type) {

					case 'svg':
						
						var svg_obj = customdesign.fn.export_svg(include_base);
						
						if (svg_obj !== null) {			
							customdesign.fn.download(
								'data:image/svg+xml;base64,'+
								btoa(svg_obj),
								name+'.svg'
							);
							
							delete svg_obj;
						} else customdesign.fn.notice('Error on render SVG', 'error');
						
					break;
					case 'png':
						
						var h = ops.height,
							w = ops.width;
						
						if (window.devicePixelRatio == 3 && h*w >= 16777216) {
							let r = 16777216/h*w;
							h = h*r;
							w = w*r;
						};
						
						var o = ops.orien,
							bg = canvas.backgroundColor,
							multiplier = w/(stage.limit_zone.width-1),
							mp = o != 'landscape' ? multiplier : multiplier*(canvas.width/canvas.height),
							dops = {
								stage: stage,
								top: stage.limit_zone.top,
								left: stage.limit_zone.left,
								width: stage.limit_zone.width,
								height: stage.limit_zone.height,
								multiplier: mp,//Math.ceil(mp),
								is_bg: include_base === true ? 'full' : false,
								with_base: ops.with_base
							},
							data = customdesign.tools.toImage(dops),
							_canvas = document.createElement('canvas'),
							ctx = _canvas.getContext("2d"),
							img = new Image();
							
						if (multiplier > 33)
							multiplier = 33;
							
						if (typeof ops.callback != 'function') {
							ops.callback = function(data) {
								customdesign.fn.download(data, name+'.png');
							}
						};
						
						if (o != 'landscape') {
							
							_canvas.width = w;
							_canvas.height = h;
							
							img.onload = function() {
								
								var _w = this.width,
									_h = this.height;

								if (_w != w) {
									_h = (_h/_w)*w; 
									_w = w;
								}
								
								if (_h > h) {
									_w = (_w/_h)*h;
									_h = h;
								}
								
								ctx.drawImage(this, (w-_w)/2, 0, _w, _h);
									
								customdesign.f('false');
								
								ops.callback(_canvas.toDataURL());
								
								delete _canvas;
								delete ctx;
								
							};
							
							img.src = data;
							
						} else {
							
							multiplier = (w/stage.limit_zone.width) < 33 ? h/stage.limit_zone.width : 33;
							
							var data = customdesign.tools.toImage({
								stage: stage,
								width: stage.limit_zone.width,
								left: stage.limit_zone.left,
								multiplier: mp,
								is_bg: include_base === true ? 'full' : false
							});
								
							_canvas.width = w;
							_canvas.height = h;
							
							img.onload = function() {
								
								ctx.translate(_canvas.width / 2, _canvas.height / 2);
								ctx.rotate(Math.PI / 2);
								
								var ih = w,
									iw = w*(this.width/this.height);
								
								if (iw > w) {
									ih = ih * (w/iw);
									iw = w;
								}
								
								if (ih > h) {
									iw = iw * (h/ih);
									ih = h;
								}
								
								ctx.drawImage(this, -iw / 2, -ih / 2, iw, ih);
							
								ctx.rotate(-Math.PI / 2);
								ctx.translate(-_canvas.width / 2, -_canvas.height / 2);
								
								customdesign.f('false');
								ops.callback(_canvas.toDataURL());
								
								delete _canvas;
								delete ctx;
								
							};
							
							img.src = data;
							
						};

					break;
					case 'jpg':

						ex.format = 'jpeg';
						customdesign.fn.download(
							canvas.toDataURL(ex), 
							name+'.jpg'
						);

					break;
					case 'pdf':
						
						customdesign.tools.discard();
						
						var stages = Object.keys(customdesign.data.stages),
							inactive = stages.filter(function(s) {
								return customdesign.data.stages[s].canvas === undefined;
							}),
							data = [],
							ratio = [],
							fonts = [],
							do_export = function() {
									
								var exp = customdesign.fn.export_svg(include_base, true),
									stage = customdesign.stage();
								
								data.push([exp[0], customdesign.get.size()]);
								
								if (!customdesign.get.el('print-base').prop('checked'))
									ratio.push((stage.edit_zone.width/stage.edit_zone.height).toFixed(5));
								else ratio.push((stage.product.width/stage.product.height).toFixed(5));
								
								exp[1].map(function(f) {
									if (fonts.indexOf(f) === -1)
										fonts.push(f);
								});
								
							},
							do_activ = function(i) {
								
								customdesign.active_stage(stages[i], function() {
									
									do_export();
									
									if (stages[i+1] !== undefined)
										do_activ(i+1);
									else 
										do_upload(data, fonts);
								});
								
							},
							do_upload = function(data, fonts) {
								
								var pdf_render = window.open(
									customdesign.data.ajax+'&action=pdf&nonce=CUSTOMDESIGN-SECURITY:'+
									customdesign.data.nonce+(fonts.length > 0 ? '&fonts='+encodeURIComponent(fonts.join('|')) : '')+
									(customdesign.get.el('print-cropmarks').prop('checked') ? '&cropmarks=1' : '')
								);
								
								customdesign.f(false);
								
								if (pdf_render === null) {
									alert('Please allow popup on this site');
									return;
								};
								
								pdf_render.addEventListener('load', function() {
									this.window.renderPDF(data, URL);
								});
								return;
								
								
								
								customdesign.f('Start uploading..');
			
								var boundary = "---------------------------7da24f2e50046";
								var body = '--' + boundary + '\r\n'
								         + 'Content-Disposition: form-data; name="file";'
								         + 'filename="temp.txt"\r\n'
								         + 'Content-type: plain/text\r\n\r\n'
								         + data.join('<!-----Customdesign break page------>') + '\r\n'+ '--'+ boundary + '--';
								         
								$.ajax({
								    contentType: "multipart/form-data; boundary="+boundary,
								    data	:	 body,
								    type	:	 "POST",
								    url		:	 customdesign.data.ajax+
								    	 '&action=render_pdf'+
								    	 '&ajax=frontend'+
								    	 '&name='+encodeURIComponent($('#customdesign-product header name t').text())+
								    	 '&nonce=CUSTOMDESIGN-SECURITY:'+customdesign.data.nonce,
								    xhr		:	 function() {
									    var xhr = new window.XMLHttpRequest();
									    xhr.upload.addEventListener("progress", function(evt){
									      if (evt.lengthComputable) {
									        var percentComplete = evt.loaded / evt.total;
									        if (percentComplete < 1)
									       		$('div#CustomdesignDesign').attr({'data-msg': parseInt(percentComplete*100)+'% upload complete'});
									       	else $('div#CustomdesignDesign').attr({'data-msg': customdesign.i(159)});
									      }
									    }, false);
									    return xhr;
									},
								    success	:	 function (res, status) {
									    customdesign.f(false);
									    if (res.indexOf('user_data') !== 0 || res.indexOf('.pdf') === -1) {
										    alert(res);
										    return;
									    }
									    var a = document.createElement('a');
										a.download = name+'.pdf';
										a.href = customdesign.data.upload_url+res;
										a.click();
										delete a;
									    
								    }
								});
							};
						
						if (ops.full === undefined || ops.full !== true) {
							do_export();
							return do_upload(data, fonts);
						};
						
						if (inactive.length > 0) {
							customdesign.active_stage(inactive[0], function(){
								customdesign.fn.download_design(ops);
							});
							return;
						};
							
						customdesign.f('Start rendering..');
						
						do_activ(0);

					break;
					
					case 'json':
						
						var data = {
							stages : {},
							type : customdesign.data.type,
							updated: new Date().getTime()/1000,
							name : customdesign.data.name
						}, sts = [];
						
						//ONLY EXPORT THE CURENT STAGE FOR TEMPLATE PURPOSE (.active)
						
						customdesign.get.el('stage-nav').find('li[data-stage].active').each(function(){

							var s = this.getAttribute('data-stage'),
								stage = customdesign.data.stages[s],
								objs, padding;

							if (stage.canvas) {
								
								data.stages['customdesign'] = {
									data 		: customdesign.tools.export(stage),
									screenshot	: customdesign.tools.toImage({stage: stage}),
									edit_zone	: stage.edit_zone,
									image		: stage.image,
									overlay		: stage.overlay,
									updated		: data.updated
								};
								
								objs = stage.canvas.getObjects().filter(function(o) {
									if (o.evented === true) {
										return true;
									} else return false;
								});
									
								if (objs.length > 0) {
									var group = new fabric.Group(objs, {
										originX: 'center',
										originY: 'center'
									});
									padding = [
										(group.left-(group.width/2)-stage.limit_zone.left)/stage.limit_zone.width,
										(group.top-(group.height/2)-stage.limit_zone.top)/stage.limit_zone.height
									];
									stage.canvas._activeObject = null;
									stage.canvas.setActiveGroup(group.setCoords()).renderAll();
									stage.canvas.discardActiveGroup();
								} else {
									padding = [0, 0];
								};
								
								data.stages['customdesign'].padding = padding;
								sts.push(s);
								
							} else if ( stage.data ) {
								
								data.stages['customdesign'] = {
									data 		: stage.data,
									screenshot	: '',
									edit_zone	: '',
									image		: '',
									overlay		: stage.overlay,
									updated		: stage.data.updated,
									padding		: [0, 0]
								};
								
								sts.push(s);
								
							}

						});

						customdesign.fn.download(
							'data:application/octet-stream;charset=utf-16le;base64,'+btoa(JSON.stringify(data).replace(/[\u{0080}-\u{FFFF}]/gu,(v) => {return encodeURIComponent(v);})),
							name+'.lumi'
						);

					break;
				}
				
			},
			
			download : function(data, name) {
				
				customdesign.fn.dataURL2Blob(data, function(blob) {
				
					var a = $('<a href="'+URL.createObjectURL(blob)+'" download="'+name.replace(/\"/g, '')+'"></a>');
					
					if (typeof a.get(0).download != 'string') {
						customdesign.fn.notice(
							'After saving the download file, change the file type to .'+
							name.split('.')[1].toUpperCase()
						, 'notice', 5000);
						return window.open(URL.createObjectURL(blob), name);
						delete a;
					};
					
					$('body').append(a);
					a.get(0).click();
					URL.revokeObjectURL(a.href);
					a.remove();
					
				});
				
			},
			
			export_svg : function (include_base, is_pdf) {
				
				var stage =  customdesign.stage(),
					canvas = stage.canvas,
					fonts = [];
				
				if (is_pdf === undefined)
					is_pdf = false;
					
				if (include_base !== undefined && include_base === false) {
					stage.productColor.set('visible', false);
					stage.product.set('visible', false);
					var cbc = canvas.backgroundColor;
					canvas.backgroundColor = 'rgba(0,0,0,0)'
				};
					
				var svg_obj = $('<div>'+canvas.toSVG()+'</div>'),
					objs = canvas.getObjects(),
					fml = [],
					svg = svg_obj.find('svg'),
					lz = stage.limit_zone,
					ov = $('#customdesign-print-overflow').prop('checked'),
					has_imagebox = (objs.filter(function(ie) {return ie.type == 'imagebox';}).length > 0),
					radius = customdesign.stage().edit_zone.radius,
					toUni = function(txt) {
						var result = "";
					    for(var i = 0; i < txt.length; i++){
					        result += '&#x' + ('000' + txt[i].charCodeAt(0).toString(16)).substr(-4)+';';
					    };
					    return result;
					};
				
				if (include_base !== undefined && include_base === false) {
					stage.productColor.set('visible', true);
					stage.product.set('visible', true);
					canvas.backgroundColor = cbc;
				};
					
				svg_obj.find('tspan').each(function(){
					this.innerHTML = '<!--lmstart-->'+toUni(this.innerHTML)+'<!--lmend-->';
				});
				
				svg_obj.find('text').each(function(){
					
					var id = this.parentNode.getAttribute('id'),
						obj = objs.filter(function(o){
							return o.id == id;
						});
					
					if (obj.length > 0 && obj[0].charSpacing > 0)
						this.setAttribute('letter-spacing', (obj[0].charSpacing*0.001)+'em');
					
					this.setAttribute('font-family', this.getAttribute('font-family').replace(/\'/g, ''));
					
					var text_style = this.getAttribute('style')+'paint-order: stroke;';
					
					this.setAttribute('style', text_style);
					
				});
					
				if (svg_obj.find('defs').length === 0)
					svg_obj.find('svg').append("<defs></defs>");
				
				if (has_imagebox !== true) {
					var limitZ = $('<g'+(ov === true ? ' clip-path="url(#limit-zone-path)"' : '')+'></g>');
					svg.append(limitZ);
					svg.find('defs').append(
						'<clipPath id="limit-zone-path">\
							<rect x="'+lz.left+'" y="'+lz.top+'" rx="'+radius+'" ry="'+radius+'" width="'+lz.width+'" height="'+lz.height+'" />\
						</clipPath>'
					);
				};
					
				objs.map(function(o){
					
					var font = '';
					
					if (
						o && o.evented && 
						o.fontFamily !== undefined && o.fontFamily !== '' &&
						typeof o.font == 'object' && o.font.length === 2 &&
						fml.indexOf(o.fontFamily.replace(/\"/g, '')) === -1
					) {
						font = o.fontFamily.replace(/\"/g, '');
						fml.push(font);
					};
					
					if (
						o.fontFamily !== undefined && 
						o.fontFamily !== '' &&
						typeof o.font == 'string' && 
						o.font.indexOf('data:text/plain;base64') === 0
					) {
						var ff = o.font.replace(
							'data:text/plain;base64,', 
							'data:font/truetype;charset=utf-8;base64,'
						);
						font = o.fontFamily.replace(/\"/g, '');
						svg_obj.find('defs').append(
							"<style type=\"text/css\">"+
							"@font-face {font-family: '"+font+"';"+"src: url("+ff+") format('woff2');}"+
							"</style>"
						);
					};
					
					if (o.type == 'imagebox') {
						
						var ib = svg_obj.find('#'+o.id);
						
						var ib_el = objs.filter(function(ie) {return ie.imagebox !== undefined && ie.imagebox == o.id;});
						
						if (ib_el.length > 0) {
							
							var trn1 = ib.parent().attr('transform').split('(')[1].split(')')[0].split(' '),
								trn2 = svg_obj.find('#'+ib_el[0].id).parent().attr('transform').split('(')[1].split(')')[0].split(' ');
							svg_obj.find('defs').append(
								'<clipPath id="imagebox-'+o.id+'">\
									<rect transform="translate('+(parseFloat(trn1[0])-parseFloat(trn2[0]))+' '+(parseFloat(trn1[1])-parseFloat(trn2[1]))+')" x="'+ib.attr('x')+'" y="'+ib.attr('y')+'" rx="0" ry="0" width="'+o.width+'" height="'+o.height+'" />\
								</clipPath>'
							);
							svg_obj.find('#'+ib_el[0].id).parent().get(0).setAttribute('clip-path', 'url(#imagebox-'+o.id+')');
						};
						
						if (ib.parent().get(0).tagName == 'g')
							ib.parent().remove();
						else ib.remove();
						
					};
					
					if (o.full_src !== undefined && o.full_src !== '')
						svg_obj.find('image#'+o.id).attr({'xlink:href': o.full_src});
					
					if (o && o.evented && !has_imagebox) {
						limitZ.append(
							svg_obj.find('#'+o.id).parent().get(0) && 
							svg_obj.find('#'+o.id).parent().get(0).tagName == 'g' ? 
							svg_obj.find('#'+o.id).parent() : 
							svg_obj.find('#'+o.id)
						);
					};
					
					if (font !== '' && fonts.indexOf(font) === -1)
						fonts.push(font);
					
				});
				
				if (fml.length > 0) {
					svg_obj.find('defs').append(
						'<style type="text/css">@import url(\'http://fonts.googleapis.com/css?family='+fml.join('|')+'\');</style>'
					);
				};
				
				svg_obj.find('desc').html(
					'Created with Customdesign Product Designer Tool (https://www.customdesign.com)'
				);
				
				svg_obj.find('img').each(function() {
					
					var attributes = $(this).prop("attributes"),
						image_el = $('<image></image>');
					$.each(attributes, function() {
					    image_el.attr(this.name, this.value);
					});
					
					$(this).after(image_el);
					$(this).remove();
					
				});
				
				svg_obj.find('image').each(function() {
					
					var src = this.getAttribute('xlink:href');
					
					if (src.indexOf('http') === 0) {
						
						var id = this.getAttribute('id'),
							canvas = document.createElement('canvas'), 
							ctx = canvas.getContext('2d'),
							obj = customdesign.stage().canvas.getObjects().filter(function(o){
								return o.id == id;
							});
						
						if (obj.length === 0 && src == customdesign.stage().product._element.src)
							obj = [customdesign.stage().product];
							
						if (obj.length === 0)
							return;
						
						var el = obj[0]._element;
							
						canvas.width = el.width;
						canvas.height = el.height;
						
						ctx.drawImage(el, 0, 0, el.width, el.height);
						
						this.setAttribute(
							'xlink:href', 
							canvas.toDataURL('image/'+(src.indexOf('.png') ? 'png' : 'jpeg'))
						);
						
					}
				});
				
				var stage = customdesign.stage();
				
				stage.canvas.getObjects().
				filter(function(o){
					return o.type == 'svg';
				}).
				map(function(o, i){
					
					var el = svg_obj.find('image[id="'+o.id+'"]'),
						sv = $('<div>'+atob(o.src.split(',')[1])+'</div>'),
						s_v = sv.find('svg').get(0),
						vb = s_v.getAttribute('viewBox') ? 
							 s_v.getAttribute('viewBox') : 
							 s_v.getAttribute('viewbox');
			 
					vb = vb.replace(/\,/g, ' ').replace(/  /g, ' ').split(' ');
					
					if (!s_v.getAttribute('width'))
						s_v.setAttribute('width', vb[2]);
						
					if (!s_v.getAttribute('height'))
						s_v.setAttribute('height', vb[3]);
					
					var x = parseFloat(vb[0]),
						y = parseFloat(vb[1]),
						
						w = parseFloat(s_v.getAttribute('width').toString().replace(/[^0-9.\-]/g, '')),
						h = parseFloat(s_v.getAttribute('height').toString().replace(/[^0-9.\-]/g, '')),
						rx = o.width/parseFloat(vb[2]),
						ry = o.height/parseFloat(vb[3]),
						
						l = (o.width/2)+(x*rx),
						t = (o.height/2)+(y*ry),
						g = '<g transform="translate(-'+l+' -'+t+') scale('+rx+' '+ry+')">';
					
					$.each(s_v.attributes, function(){
						if (this.name.indexOf('xmlns:') === 0 && !svg_obj.find('svg').attr(this.name))
							svg_obj.find('svg').attr(this.name, this.value);
					});
					/*
					* Fix stroke width of inner svg object
					*/
					$(s_v).find('[stroke-width]').each(function(){
						this.setAttribute('stroke-width', parseFloat(this.getAttribute('stroke-width')*rx));
					});
					
					g += s_v.innerHTML+'</g>';
					
					el.after(g);
					el.remove();
					
					return;
					
					
					var canvas = document.createElement('canvas'), 
					ctx = canvas.getContext('2d');
					canvas.width = o._element.width*5;
					canvas.height = o._element.height*5;
					ctx.drawImage(o._element, 0, 0, o._element.width*5, o._element.height*5);
					
					svg_obj.find('image[id="'+o.id+'"]').get(0).setAttribute(
						'xlink:href', 
						canvas.toDataURL('image/png')
					);
					
				});
				
				if (include_base !== undefined && include_base === false) {
					
					svg.attr({
						width: 800,
						height: lz.height*(800/lz.width)
					});
					
					svg.get(0).setAttribute('viewBox', (lz.left)+' '+(lz.top)+' '+(lz.width)+' '+(lz.height));
					
				} else if (include_base !== undefined && include_base === true) {
					svg.attr({
						width: stage.product.width,
						height: stage.product.height
					});
					
					svg.get(0).setAttribute('viewBox', (stage.product.left-(stage.product.width/2))+' '+(stage.product.top-(stage.product.height/2))+' '+(stage.product.width)+' '+(stage.product.height));
					
				}
				
				if (is_pdf) {
					svg.removeAttr('width');
					svg.removeAttr('height');
				};
				
				var svg_data = svg_obj.html();
				
				svg_data = svg_data.split('<!--lmstart-->');
				
				svg_data.map(function(s, i) {
					if (i>0 && s.indexOf('<!--lmend-->') > -1) {
						s = s.split('<!--lmend-->');
						s[0] = toUni(s[0]);
						svg_data[i] = s.join('');
					};
				});
				
				svg_data = svg_data.join('').replace(/gradienttransform/g, 'gradientTransform').
							replace(/gradientunits/g, 'gradientUnits').
							replace(/lineargradient/g, 'linearGradient').
							replace(/radialgradient/g, 'radialGradient').
							replace(/\<\/clippath\>/g, '</clipPath>').
							replace(/\<clippath\ /g, '<clipPath ').
							replace(/\>\<\/stop\>/g, '/>');
				
				/*$('#svg-preview').remove();
				$('body').append('<div id="svg-preview" style="position: fixed; top: 50px; right: 50px;z-index: 100000000000000000">'+svg_data+'</div>');
				return null;*/
				
				if (is_pdf === false)
					return svg_data;
				else return [svg_data, fonts];
									
			},
			
			dataURL2Blob : function(dataURL, callback) {

				callback(this.url2blob(dataURL));

			},

			process_files: function(files, callback, saveas) {

				var tmpl = '', file, reader  = {};
				
				for (f in files) {
					
					if (typeof files[f] != 'object')
						return;
					
					if (files[f].type.indexOf('image/') !== 0)
						return customdesign.fn.notice(customdesign.i('148'), 'error', 5000);
						
					file = files[f];

					reader[f] = new FileReader();
					reader[f].f = f;
					reader[f].file = file;
					reader[f].addEventListener("load", function () {
						
						if (!customdesign.fn.check_upload_size(reader[this.f].file)) {
							delete reader[this.f];
							return;
						};
						
						var id = parseInt(reader[this.f].file.lastModified/1000).toString(36);

						id = parseInt((new Date().getTime()/1000)).toString(36)+'-'+id;
						
						var url_data = this.result,
							img_opt = {
								url: url_data,
								type: reader[this.f].file.type,
								size: reader[this.f].file.size,
								name: reader[this.f].file.name.replace(/[^0-9a-zA-Z\.\-\_]/g, "").trim().replace(/\ /g, '+')
							};
						
						if (url_data.indexOf('data:image/svg+xml;base64,') === 0) {
							
							var wrp = $('<div>'+atob(url_data.split('base64,')[1]).replace('viewbox=', 'viewBox=')+'</div>'),
								svg = wrp.find('svg').get(0),
								vb = svg.getAttribute('viewBox') ? 
									 svg.getAttribute('viewBox') : 
									 svg.getAttribute('viewbox');
								
								if (vb === null)
									return;
								
								vb = vb.replace(/\,/g, ' ').replace(/  /g, ' ').split(' ');
								
								if (!svg.getAttribute('width'))
									svg.setAttribute('width', vb[2]);
									
								if (!svg.getAttribute('height'))
									svg.setAttribute('height', vb[3]);
								
							wrp.find('[id]').each(function(){
								this.id = this.id.replace(/[\u{0080}-\u{FFFF}]/gu,"");
							});
							
							img_opt.url = 'data:image/svg+xml;base64,'+btoa(wrp.html());
							
							if (saveas !== false)
								new customdesign.cliparts.import(id, img_opt, 'prepend');
							
						} else if (saveas !== false) {
							new customdesign.cliparts.import(id, img_opt, 'prepend');
				    	};
				    	
				    	if (typeof callback == 'function')
				    		callback(img_opt);
				    		
				    	delete reader[this.f];

					}, false);

					reader[f].readAsDataURL(file);

				};

			},
			
			select_image: function(callback, saveas) {
					
				var ops = customdesign.ops; 
				
				if (ops.image_inp === undefined) {
					ops.image_inp = document.createElement('input');
					ops.image_inp.type = 'file';
					ops.image_inp.accept = '.jpg,.png,.jpeg,.svg';
					ops.image_inp.onchange = function(){
						customdesign.fn.process_files(this.files, this.callback, this.saveas);
					};
				};
				
				ops.image_inp.type = 'text';
				ops.image_inp.value = '';
				ops.image_inp.type = 'file';
				ops.image_inp.callback = callback;
				ops.image_inp.saveas = saveas;
				ops.image_inp.click();
				
			},
			
			replace_image: function(url, image) {
				
				customdesign.f(false);
				
				customdesign.fn.crop({
					src: url,
					width: image.width,
					dimension: image.width/image.height,
					square: false,
					load: function(img, crop) {
						
						var are = crop.find('div.customdesign_crop_selArea'),
							pw = are.parent().width(),
							ph = are.parent().height(),
							w = pw*0.9,
							h = w*(image.height/image.width);
							
						if (h < ph) {
							are.css({
								width: w+'px',
								height: h+'px',
								top: ((ph-h)/2)+'px',
								left: ((pw-w)/2)+'px',
							});
						} else {
							h = ph*0.9;
							w = h*(image.width/image.height);
							are.css({
								width: w+'px',
								height: h+'px',
								top: ((ph-h)/2)+'px',
								left: ((pw-w)/2)+'px',
							});
						}
						
						crop.trigger('mousedown').off('mousemove touchmove');
						
					},
					save: function(crop) {
						
						var s = customdesign.stage(),
							active = s.canvas.getActiveObject(),
							el = crop.find('.customdesign_crop_selArea');
							
						if (active) {

							var _e = el.get(0), 
								_c = crop.get(0),
								img = crop.find('img.customdesign_crop_img').get(0),
								cv = document.createElement('canvas'),
								ctx = cv.getContext('2d'),
								type = customdesign.fn.get_type(img.src),
								
								w = img.naturalWidth*(_e.offsetWidth/_c.offsetWidth),
								h = img.naturalHeight*(_e.offsetHeight/_c.offsetHeight),
								
								iw = active.width,
								ih = iw*(el.height()/el.width());
							
							cv.width = w;
							cv.height = h;
							
							ctx.drawImage(
								img, 
								-_e.offsetLeft*(img.naturalWidth/_c.offsetWidth),
								-_e.offsetTop*(img.naturalHeight/_c.offsetHeight),
								img.naturalWidth, 
								img.naturalHeight
							);
							
							var src = cv.toDataURL('image/'+type);
							
							delete cv;
							delete ctx;
							
							if (
								w > s.limit_zone.width ||	
								h > s.limit_zone.height
							) {
								setTimeout(customdesign.fn.large_image_helper, 1, {
									w: w,
									h: h,
									ew: s.limit_zone.width,
									eh: s.limit_zone.height,
									iw: iw,
									ih: ih,
									el: cv,
									obj: active,
									src: src, 
									callback: function() {
										customdesign.ops.importing = false;
										customdesign.stack.save();
									}
								});
							} else {
								active.setSrc(src, function() {
									active.set({
										full_src: '',
										width: active.width,
										height: active.width*(el.height()/el.width()),
										origin_src: src,
										src: src,
										type: 'image'
									});
									s.canvas.renderAll();
								});
							}
						};
						
						
						return;
						
						
						var s = customdesign.stage(),
							main_canvas = s.canvas,
							active = image,
							img = crop.find('img.customdesign_crop_img').get(0),
							type = img.src.indexOf('data:image/jpeg') ? 'jpeg' : 'png',
							canvas = document.createElement('canvas'),
							ctx = canvas.getContext('2d'),
							area = crop.find('div.customdesign_crop_selArea'),
							w = area.width(),
							h = area.height(),
							t = area.get(0).offsetTop,
							l = area.get(0).offsetLeft;
							
						canvas.width = w;
						canvas.height = h;
						
						ctx.drawImage(img, -l, -t, area.parent().width(), area.parent().height());
						
						var ow = active.width,
							oh = active.height,
							src = canvas.toDataURL('image/'+type);
									
						delete canvas;
						delete ctx;
						
						active.setSrc(src, function() {
							active.set({
								width: ow,
								height: ow*(h/w),
								origin_src: src,
								src: src,
								type: 'image'
							});
							main_canvas.renderAll();
						});
							
						delete canvas;
						
					}
				});
					
			},
			
			imagebox_select_file: function(ib) {
				
				this.select_image(function(opt) {
					customdesign.tools.import ({objects: [{
						type: 'image',
						src: opt.url,
						width: ib.width,
						left: ib.left,
						top: ib.top,
						imagebox: ib.id,
						evented: true
					}]}, function(){});
				});
				
			},
			
			imagebox_arrange: function() {
				
				var stage = customdesign.stage(),
					canvas = stage.canvas,
					objs = canvas.getObjects();
					
				objs.map(function(o) {
					if (o.type == 'imagebox')
						o.moveTo(2);
				});
				
				canvas.renderAll();
					
			},
			
			preset_import : function(data, pos, callback) {
				
				var stage = customdesign.stage();

				customdesign.f('Loading..');

				pos = $.extend({
					width: stage.limit_zone.width*0.8,
					left: stage.limit_zone.left + (stage.limit_zone.width/2),
					top: stage.limit_zone.top + (stage.limit_zone.height/2)
				}, pos);
				
				data.map(function(d, i) {
					
					if (d.type == 'upload')
						d.type = 'image';
					
					if (d.id) {
						if (customdesign.cliparts.uploads[d.id])
							d.url = customdesign.cliparts.uploads[d.id];
						else if (customdesign.cliparts.storage[d.id])
							d.url = customdesign.cliparts.storage[d.id];
					}

					if (d.text && !d.name)
						d.name = d.text.substr(0, 30);

					if (d.url){
						if (d.url.indexOf('data:image/svg+xml;base64,') > -1 || d.url.split('.').pop().trim() == 'svg') {
							d.type = 'svg';
						}else d.type = 'image';
						d.src = d.url;
						delete d.url;
					}
					
					if (d.font !== undefined && decodeURIComponent(d.font) != d.font)
						d.font = JSON.parse(decodeURIComponent(d.font));
					
					Object.keys(pos).map(function(i){
						if (['left', 'top'].indexOf(i) > -1 && d[i] !== undefined)
							d[i] += pos[i];
						else if (d[i] === undefined)
							d[i] = pos[i];
					});

					if (!d.name)
						(d.name = d.url && d.url.indexOf('data:image') === -1) ?
							d.url.split('/').pop() :
							(d.type == 'svg' ? 'New SVG' : 'New Image');
					
					var fill_default = customdesign.get.color('invert');
				
					if (customdesign.data.colors !== undefined && customdesign.data.colors !== '') {
						fill_default = customdesign.data.colors.split(',')[0];
						if (fill_default.indexOf(':') > -1)
							fill_default = fill_default.split(':')[1];
						fill_default = fill_default.split('@')[0];
					};
					
					if (d.type == 'i-text' || d.type == 'text-fx') {
						d.fill = fill_default;
					}

					delete d.save;
					data[i] = d;

				});
				
				customdesign.tools.import ({objects: data}, function(){
					customdesign.get.el('x-thumbn-preview').hide();
					setTimeout(function(){
						if (customdesign.ops.set_active) {
							stage.canvas.setActiveObject(customdesign.ops.set_active);
							delete customdesign.ops.set_active;
						} else stage.canvas.setActiveObject(stage.canvas._objects[stage.canvas._objects.length-1]);
						customdesign.tools.save();
						if (typeof callback == 'function')
							callback();
					}, 10);
				});

			},

			update_edit_zone : function(img, stage) {

				var ratio = stage.product.height/img.naturalHeight;

				if (ratio !== 1) {
					stage.limit_zone.set({
						height: stage.edit_zone.height*ratio,
						width: stage.edit_zone.width*ratio,
						left: (stage.edit_zone.left*ratio)+(stage.canvas.width/2),
						top: (stage.edit_zone.top*ratio)+(stage.canvas.height/2)
					});
				}

				if (img.naturalWidth > 600) {
					stage.product.set({
						width: 600,
						height: img.naturalHeight*(600/img.naturalWidth)
					});
				}else{
					stage.product.set({
						width: img.naturalWidth,
						height: img.naturalHeight*(600/img.naturalWidth)
					});
				}
				stage.canvas.renderAll();
			},

			ctrl_btns : function(opts) {
				
				if (!opts.e)
					return false;

				var target = opts.target,
					objs = target._objects,
					canvas = customdesign.stage().canvas,
					active = canvas.getActiveObject(),
					group = canvas.getActiveGroup(),
					corner = target._findTargetCorner(canvas.getPointer(opts.e, true));

				if (canvas.isDrawingMode === true)
					return;

				if (corner == 'tl') {
					
					customdesign.tools.discard();
					customdesign.stack.save();
					
					if (objs && objs.length > 0)
						objs.map(function(obj){
							canvas.remove(obj);
						});
					else canvas.remove(target);

					customdesign.stack.save();
					customdesign.design.layers.build();
					customdesign.actions.do('object:remove');
					return true;

				}else if (corner == 'bl') {
					
					customdesign.fn.do_double();
					return true;

				}

			},

			navigation : function(el, e) {
				
				if (customdesign.ops.preventClick === true)
					return delete customdesign.ops.preventClick;
				
				if (el === 'clear' || $(el).hasClass('active')){
						
					if(
						el !== 'clear' &&
						typeof e !== 'undefined' &&
						el.getAttribute('data-tool') === 'cart' &&
						e.target.getAttribute('data-func') === 'remove'
					)return;
				
					$('[data-navigation="active"]').attr({'data-navigation': ''});
					customdesign.e.main.find('li[data-tool].active').removeClass('active');
					
				}else{
					
					$('[data-navigation="active"]').attr({'data-navigation': ''});
					
					if (el.getAttribute('data-tool') === 'languages' && !customdesign.data.switch_lang) 
						return;
					
					customdesign.e.main.find('li[data-tool].active').removeClass('active');
					
					$(el).addClass('active');
					$(el).closest('[data-navigation]').attr({'data-navigation': 'active'});
					
				}
			},

			set_cookie : function(cname, cvalue, exdays) {

			    var d = new Date();
			    if (!exdays)
			    	exdays = 365;

			    d.setTime(d.getTime() + (exdays*24*60*60*1000));
			    var expires = "expires="+ d.toUTCString();
			    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

			},

			get_cookie : function(cname) {

			    var name = cname + "=";
			    var decodedCookie = decodeURIComponent(document.cookie);
			    var ca = decodedCookie.split(';');
			    for(var i = 0; i <ca.length; i++) {
			        var c = ca[i];
			        while (c.charAt(0) == ' ') {
			            c = c.substring(1);
			        }
			        if (c.indexOf(name) == 0) {
			            return c.substring(name.length, c.length);
			        }
			    }

			    return "";

			},

			getTextWidth : function(op, callback) {
				
				if (typeof callback != 'function')
					return;
					
				if (!document.fonts) {
					return callback({width: 0, height: 0});	
				}
				
				document.fonts.load(op.size+'px "'+op.family+'"', op.text).then(function(){

				    var canvas = customdesign.ops.getTextWidthCanvas || (customdesign.ops.getTextWidthCanvas = document.createElement("canvas"));
				    var context = canvas.getContext("2d");
				    context.font = op.size+'px '+op.family;
				    var metrics = context.measureText(op.text);

				    callback (metrics);

				});

			},
			
			buildText : function(ops) {
				
				if (customdesign.ops.texttmpl === undefined) {
					customdesign.ops.texttmpl = $('<div style="display: inline-block;visibility:hidden;white-space: nowrap;position:fixed;top: -10000px;left: -1000px;"></div>');
					$('body').append(customdesign.ops.texttmpl);
				};
				
				if (ops.curved === undefined || ops.curved === 0)
					ops.curved = 1;
					
				if (ops.curved > 1)
					ops.text = ops.text.trim().replace(/\n/g, ' ');
				
				customdesign.ops.texttmpl.html(ops.text.trim().replace(/\n/g, '<br>')).
					css({
						'line-height': ops.lineHeight+'px', 
						'letter-spacing': (ops.charSpacing)+'px', 
						'font-size': ops.fontSize+'px',
						'font-family': ops.fontFamily
					});
				
				var h = customdesign.ops.texttmpl[0].getBoundingClientRect(),
		            w = h.width-ops.charSpacing,
		            h = h.height,
		            m1 = 0, m2 = 0, a4 = 0, a5 = 0, a6 = 0, a7 = 0,
		            e = ops.curved,
		            rtl = ops.rtl,
		            spc = ops.charSpacing !== undefined ? ops.charSpacing : 0,
		            txt = ops.text,
		            lh = ops.lineHeight !== undefined && ops.lineHeight !== 0 ? ops.lineHeight : ops.fontSize;
		        
		        if (e > 1) {
			            
			        e >= 360 && (e = 359.999), 
			        -360 >= e && (e = -359.999), 
			        e >= 0 && 180 >= e ? (a4 = 0, a5 = 1) : e > 180 && 360 >= e ? (a4 = 1, a5 = 1) : 0 > e && e > -180 ? (a4 = 0, a5 = 0) : -180 >= e && e >= -360 && (a4 = 1, a5 = 0);
					
					var r = (180 * w) / (Math.abs(e) * Math.PI),
						b = 90 - Math.abs(e) / 2,
			            c = 90 + Math.abs(e) / 2,
			            v = b * Math.PI / 180,
			            M = c * Math.PI / 180,
			            f = r * Math.cos(v),
			            g = r * Math.sin(v),
			            N = r * Math.cos(M),
			            S = r * Math.sin(M),
			            tp = new Date().getTime();
			            
						e > 0 ? (
							f = -1 * f, 
							g = -1 * g, 
							N = -1 * N, 
							S = -1 * S
						) : (
							f = -1 * f, 
							N = -1 * N
						),
				        Math.abs(e) > 180 ? r + Math.abs(g) : r - Math.abs(g), 
			        	e > 0 ? (
				        	m1 = f + r, 
				        	m2 = g + r, 
							a6 = N + r, 
							a7 = S + r
						) : (
							m1 = f, 
							m2 = g, 
							a6 = N, 
							a7 = S
						);
				
				};
				
				var svg_text = '';
				
				txt.trim().split("\n").map(function(t, i) {
					svg_text += '<text fill="'+ops.fill+'" stroke="'+ops.stroke+'" stroke-width="'+(ops.strokeWidth*10)+'" stroke-linecap="butt" stroke-linejoin="miter" font-size="'+ops.fontSize+'" font-family="'+ops.fontFamily+'" letter-spacing="'+spc+'" '+(rtl ? 'text-anchor="end" direction="rtl"' : 'text-anchor="start" direction="ltr"')+'>'+(e == 1 ? '' : '<textPath xlink:href="#tp-'+tp+'">');
					svg_text += '<tspan dy="'+(i*lh)+'" x="'+(e == 1 ? spc/2 : 0)+'">'+t+'</tspan>'+(e == 1 ? '' : '</textPath>')+'</text>';
				});
				
				var svg = $('<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g>'+svg_text+(e == 1 ? '' : '</g><path id="tp-'+tp+'" d="M '+m1+' '+m2+' A '+r+' '+r+' 0 '+ a4 + ' ' + a5 + ' ' + a6 + " " + a7+'" fill="transparent"></path>')+'</svg>');
				
				customdesign.ops.texttmpl.html('').append(svg);
				
				var text = svg.find('g').get(0).getBoundingClientRect();
				
				if (
					(ops.textAlign == 'center' || ops.textAlign == 'right') &&
					svg.find('text tspan').length > 1
				) {
					svg.find('text tspan').each(function(){
						var tbc = this.getBoundingClientRect().width;
						if (ops.textAlign == 'center' && tbc < text.width)
							this.setAttribute('x', (text.width-tbc)/2);
						if (ops.textAlign == 'right' && tbc < text.width)
							this.setAttribute('x', (text.width-tbc));
					});
				};
				
				svg.attr({
					height: text.height,
					width: text.width+spc,
					viewBox: (e == 1 ? 0 : m1-f-(text.width/2))+' -'+(ops.fontSize*0.9)+' '+(text.width+spc)+' '+(text.height)
				});
				
				return customdesign.ops.texttmpl.html();
				
			},
			
			url2blob : function(dataURL) {

				if(typeof dataURL !== 'string'){
			        throw new Error('Invalid argument: dataURI must be a string');
				}

			    dataURL = dataURL.split(',');

				var binStr = atob(dataURL[1]),
					len = binStr.length,
					arr = new Uint8Array(len);

				for (var i = 0; i < len; i++) {
					arr[i] = binStr.charCodeAt(i);
				}

				return new Blob([arr], {
					type: dataURL[0].substring(dataURL[0].indexOf('image/'), dataURL[0].indexOf(';')-1)
				});
			},

			createThumbn : function(ops) {

				var img = new Image();
		    		img.onload = function(){

			    		var cv = customdesign.ops.creatThumbnCanvas ?
			    				 customdesign.ops.creatThumbnCanvas :
			    				 customdesign.ops.creatThumbnCanvas = document.createElement('canvas');

			    		cv.width = ops.width;
			    		cv.height = ops.height;
			    		var ctx = cv.getContext('2d'),
			    			w = this.naturalHeight*(cv.width/this.naturalWidth) >= cv.height ?
			    				cv.width : this.naturalWidth*(cv.height/this.naturalHeight),
			    			h = w == cv.width ? this.naturalHeight*(cv.width/this.naturalWidth) : cv.height,
			    			l = w == cv.width ? 0 : -(w-cv.width)/2,
			    			t = h == cv.height ? 0 : -(h-cv.height)/2;

			    		ctx.fillStyle = ops.background? ops.background : '#eee';
						ctx.fillRect(0, 0, cv.width, cv.height);
			    		ctx.drawImage(this, l, t, w, h);

			    		ops.callback(cv);

		    		};
		    		
		    	img.src = ops.source;

			},
			
			check_upload_size : function(file) {
				
				var show_notice = customdesign.apply_filters('upload_notice', true);
						
				if (
					!isNaN(customdesign.data.min_upload) && 
					customdesign.data.min_upload > 0 &&
					file.size/1024 < customdesign.data.min_upload
				) {
					if (show_notice) 
						customdesign.fn.notice(customdesign.i('147')+' '+(file.size/1024).toFixed(2)+'KB (Minimum '+customdesign.data.min_upload+'KB)', 'error', 8000);
					
					customdesign.do_action('upload_minimum_limit');
					return false;
				};
				
				if (
					!isNaN(customdesign.data.max_upload) && 
					customdesign.data.max_upload > 0 &&
					file.size/1024 > customdesign.data.max_upload
				) {
					if (show_notice) 
						customdesign.fn.notice(customdesign.i('147')+' '+(file.size/1024).toFixed(2)+'KB (Maximum '+customdesign.data.max_upload+'KB)', 'error', 8000);
					
					customdesign.do_action('upload_maximum_limit');
					return false;
				};	
				
				return true;
				
			},
			
			check_upload_dimensions : function(img) {
			
				let src = img.src, 
					type = 'jpeg';
				
				if (img.src.indexOf('data:image/png') === 0 || img.src.split('.').slice(-1)[0].toLowerCase() == 'png')
					type = 'png'; 
				
				if (img.src.indexOf('data:image/svg+xml') === 0) 
					return src;
					
				if (
			    	customdesign.data.min_dimensions !== '' && 
			    	typeof customdesign.data.min_dimensions == 'object'
			    ) {
				    if (
				    	parseFloat(customdesign.data.min_dimensions[0]) > img.width ||
				    	parseFloat(customdesign.data.min_dimensions[1]) > img.height
				    ) {
					    customdesign.fn.notice(customdesign.i(160)+' '+customdesign.data.min_dimensions.join('x'), 'notice', 3500);
						return null;
				    }	
			    };
			    
			    if (
			    	customdesign.data.max_dimensions !== '' && 
			    	typeof customdesign.data.max_dimensions == 'object'
			    ) {
				    
				    if (
				    	parseFloat(customdesign.data.max_dimensions[0]) < img.width ||
						parseFloat(customdesign.data.max_dimensions[1]) < img.height
				    ) {
					    
					    var cv = document.createElement('canvas');
					    
					    if (parseFloat(customdesign.data.max_dimensions[0]) < img.width) {
						    
						    cv.width = parseFloat(customdesign.data.max_dimensions[0]);
						    cv.height = cv.width*(img.height/img.width);
						    
						    if (cv.height > customdesign.data.max_dimensions[1]) {
							    cv.width = customdesign.data.max_dimensions[1]*(cv.width/cv.height);
							    cv.height = customdesign.data.max_dimensions[1];
						    };
						    
					    } else if (parseFloat(customdesign.data.max_dimensions[1]) < img.height) {
						    
						    cv.height = parseFloat(customdesign.data.max_dimensions[1]);
						    cv.width = cv.height*(img.width/img.height);
						    
						    if (cv.width > customdesign.data.max_dimensions[0]) {
							    cv.height = customdesign.data.max_dimensions[0]*(cv.height/cv.width);
							    cv.width = customdesign.data.max_dimensions[0];
						    };
					    
					    };
					    
					    cv.getContext('2d').drawImage(img, 0, 0, cv.width, cv.height);
					    
					    src = cv.toDataURL('image/'+type);
					    
				    }
					
				};
				
				let size = customdesign.get.size();
				
				if (customdesign.data.min_ppi !== '') {
					
					var pi = 300/parseFloat(customdesign.data.min_ppi);
		
				    if (
				    	img.width*pi < size.w ||
				    	img.height*pi < size.h
				    ) {
					    if (customdesign.data.ppi_notice == '1') {
						    customdesign.fn.notice(customdesign.i(197), 'notice', 3500);
						    return img.src;
					    }
					    customdesign.fn.notice(customdesign.i(194)+' '+customdesign.data.min_ppi, 'notice', 3500);
						return null;
				    }	
			    };
			   
				if (customdesign.data.max_ppi !== '') {
					
					var pi = 300/parseFloat(customdesign.data.max_ppi);
					
				    if (
				    	img.width*pi > size.w ||
				    	img.height*pi > size.h
				    ) {
					    customdesign.fn.notice(customdesign.i(195)+' '+customdesign.data.max_ppi, 'notice', 3500);
						return null;
				    }	
			    };
				
				return src;
				
			},
			
			get_blob : function(url, callback) {

				var xhr = new XMLHttpRequest();

				xhr.open("GET", url, true);
				xhr.responseType = "blob";
				xhr.overrideMimeType("text/plain;charset=utf-8");
				xhr.onload = function(){
					var a = new FileReader();
				    a.onload = callback;
				    a.readAsDataURL(this.response);
				};
				xhr.onreadystatechange = function (e) {  
				    if (xhr.readyState === 4 && xhr.status !== 200)
				        callback(1);
				};
				
				xhr.send(null);

			},

			count_colors : function(url, callback) {

				if (!customdesign.ops.count_colors_canvas)
					customdesign.ops.count_colors_canvas = document.createElement('canvas');

				var toHex = function(c) {
					    var hex = c.toString(16);
					    return hex.length == 1 ? "0" + hex : hex;
					},
					nearest = function(x, a) {
						return Math.floor(x / (255 / a)) * (255 / a);
					},
					process = function(img, w, h) {

						customdesign.ops.count_colors_canvas.width = w;
						customdesign.ops.count_colors_canvas.height = h;

						var stats = [],
							ctx = customdesign.ops.count_colors_canvas.getContext("2d");

						ctx.drawImage(img, 0, 0, w, h);

						// get bitmap
						var idata = ctx.getImageData(0, 0, w, h),
							data = idata.data;

						for (var i = 0; i < data.length; i += 4) {

						    data[i]     = nearest(data[i],     8);
						    data[i + 1] = nearest(data[i + 1], 8);
						    data[i + 2] = nearest(data[i  +2], 4);

							c = '#'+toHex(data[i])+toHex(data[i+1])+toHex(data[i+2]);
							if (stats.indexOf(c) === -1)
								stats.push(c);

						}

						return stats;

					};

				if (callback === true)
					return process(url, url.width/10, url.height/10);

				var img = new Image();

				img.cb = callback;
				img.onload = function(){

					var w = this.naturalWidth/5,
					    h = this.naturalHeight/5,
					    stats = [],
					    nearest = function(x, a) {
						    return Math.floor(x / (255 / a)) * (255 / a);
						};

					if (typeof this.cb == 'function')
						this.cb(process(this, w, h));

					delete this;

				};

				img.src = url;

			},

			update_state : function() {
			
				clearTimeout(customdesign.ops.preventDbl);
				
				customdesign.ops.preventDbl = setTimeout(function() {
					
					var states = {}, 
						objs = [], 
						bg = [], 
						colors = [], 
						c;
					
					Object.keys(customdesign.data.stages).map(function(s){
	
						var scolors = [], image = 0, text = 0, clipart = 0, vector = 0, upload=0;
						
						objs = [];
						
						if (customdesign.data.stages[s].canvas)
							objs = customdesign.data.stages[s].canvas.getObjects();
						else if (customdesign.data.stages[s].data && customdesign.data.stages[s].data.objects)
							objs = customdesign.data.stages[s].data.objects;
	
						if (objs.length > 0) {
							objs.map(function(o){
								if (o && o.evented) {
									
									if (o.colors && o.colors.length > 0) {
										o.colors.map(function(c){
											
											c = customdesign.tools.svg.rgb2hex(c);
											
											if (colors.indexOf(c) === -1) {
												colors.push(c);
												bg.push(c);
											}
											if (scolors.indexOf(c) === -1)
												scolors.push(c);
										});
									}
									//stage colors
									if (o.stroke !== '' && o.type != 'svg') {
										
										c = customdesign.tools.svg.rgb2hex(o.stroke);
										
										if(colors.indexOf(o.stroke) === -1){
											colors.push(o.stroke);
											bg.push(c);
										}
										if(scolors.indexOf(c) === -1)
											scolors.push(c);
										
									};
									
									if (o.fill !== '' && o.type != 'svg') {
										
										c = customdesign.tools.svg.rgb2hex(o.fill);
										
										if(colors.indexOf(c) === -1){
											colors.push(c);
											bg.push(c);
										}
										if(scolors.indexOf(c) === -1)
											scolors.push(c);
									};
									
									// Do not count printing for template's objects
									if (
										o.template !== undefined && o.template.length != 0
									) {
										o.price = 0;
									};
									
									if (typeof o.resource !== 'undefined') {
										switch (o.resource) {
											case 'cliparts':
												clipart++;
												break;
											case 'shape':
												vector++;
												break;
											case 'svg':
												vector++;
												break;
											default:
												
										}
									} else {
										switch (o.type) {
											case 'image':
											case 'image-fx':
											case 'qrcode':
												image++;
												break;
											
											case 'path':
												vector++;
												break;
											case 'svg':
												vector++;
												break;
											case 'i-text':
											case 'text-fx':
											case 'curvedText':
												text++;
												break;
											default:
												
										}
									}
									
								}
							});
						};
	
						states[s] = {
							colors: scolors,
							images: image,
							vector: vector,
							clipart: clipart,
							text: text
						}
	
					});
					
					if (bg.length > 6) {
						mo = (colors.length-6)+'+';
						bg = bg.splice(bg.length - 6);
					} else mo = '';
					
					$('#customdesign-count-colors i').html(mo).css({background: 'linear-gradient(to right, '+bg.join(', ')+')'}).attr({title: 'Used '+bg.length+' colors'});
					
					customdesign.actions.do('updated', states);
					
					customdesign.get.el('status').hide();
					customdesign.ops.before_unload = null;
					
					customdesign.render.stage_nav();
					
				}, 250);
				
				//return states;

			},
			
			create_canvas : function(stage, img) {
				
				var main = customdesign.get.el('main'),
				 	name = stage.name,
					mw = main.width()-(customdesign.ops.window_width < 1025 ? 0 : 20),
					mh = main.height()-(customdesign.ops.window_width < 1025 ? -40 : 10);
					
				//if (mw < img.naturalWidth)
				//	mw = img.naturalWidth;
				
				main.append(
					'<div id="customdesign-stage-'+name+'" class="customdesign-stage canvas-wrapper" style="height: '+mh+'px;">\
						<canvas id="customdesign-stage-'+name+'-canvas" width="'+mw+'" height="'+mh+'"></canvas>\
						<div class="customdesign-snap-line-x"></div>\
						<div class="customdesign-snap-line-y"></div>\
					</div>'
				);
				
				stage.canvas = new fabric.Canvas('customdesign-stage-'+name+'-canvas', {
					preserveObjectStacking: true,
					controlsAboveOverlay: true
				});
	
				stage.product = {};
				stage.stack = {
					data : [],
				    state : true,
				    index : 0
			    };
	
				var wrp = customdesign.fn.q('#customdesign-stage-'+name);
	
				stage.lineX = $('#customdesign-stage-'+name+' .customdesign-snap-line-x');
				stage.lineY = $('#customdesign-stage-'+name+' .customdesign-snap-line-y');
				
				[
					['dragover', function(e){
	
					e.preventDefault();
	
					if (!customdesign.ops.drag_start || !customdesign.ops.drag_start.getAttribute('data-ops'))
						return;
	
					var cur = stage.limit_zone.visible,
						zoom = customdesign.stage().canvas.getZoom(),
						disc = customdesign.ops.drag_start.distance,
						view = customdesign.stage().canvas.viewportTransform,
						limit = {
							l : (stage.limit_zone.left*zoom)+view[4],
							t :  (stage.limit_zone.top*zoom)+view[5],
							w : stage.limit_zone.width*zoom,
							h : stage.limit_zone.height*zoom
						};
	
					if (
						(e.layerX - disc.x + (disc.w/2) > limit.l) &&
						(e.layerX - disc.x - (disc.w/2) < limit.l+limit.w) &&
						(e.layerY - disc.y + (disc.h/2) > limit.t) &&
						(e.layerY - disc.y - (disc.h/2) < limit.t+limit.h)
					) {
						stage.limit_zone.set('visible', true);
					}else{
						stage.limit_zone.set('visible', false);
					}
	
					if (cur != stage.limit_zone.visible)
						stage.canvas.renderAll();
	
				}],
					['dragleave', function(e){
	
						e.preventDefault();
		
						if (stage.limit_zone.visible === true) {
							stage.limit_zone.set('visible', false);
							stage.canvas.renderAll();
						}
		
					}],
					['drop', function(e){
		
						e.preventDefault();
		
						if (!customdesign.ops.drag_start || !customdesign.ops.drag_start.getAttribute('data-ops') || stage.limit_zone.visible !== true)
							return;
		
						var rect = this.getBoundingClientRect();

						var ops = customdesign.ops.drag_start.getAttribute('data-ops');
						if(customdesign.ops.drag_start.getAttribute('class') == 'customdesign-clipart' && customdesign.xitems.ops[ops] !== undefined){
							ops = $.extend(true, [], customdesign.xitems.ops[ops]);
						} else {
							ops =JSON.parse(customdesign.ops.drag_start.getAttribute('data-ops'));
						}
		
						var disc = customdesign.ops.drag_start.distance,
							zoom = customdesign.stage().canvas.getZoom(),
							view = customdesign.stage().canvas.viewportTransform;
		
						if (ops[0].type == 'shape')
							ops[0].url = 'data:image/svg+xml;base64,'+btoa(customdesign.ops.drag_start.innerHTML.trim());
						else if (ops[0].url === undefined)
							ops[0].url = customdesign.cliparts.storage[ops[0].id] || customdesign.cliparts.uploads[ops[0].id];
		
						if (ops[0].url && ops[0].url.indexOf('dumb-') === 0) {
							customdesign.indexed.get(ops[0].url.split('dumb-')[1], 'dumb', function(res){
								if (res !== null) {
									customdesign.cliparts.uploads[ops[0].id] = res[0];
									ops[0].url = res[0];
									customdesign.fn.preset_import(ops, {
										left: (((e.clientX - rect.left)/zoom) - disc.x)-(view[4]/zoom),
										top: (((e.clientY - rect.top)/zoom) - disc.y)-(view[5]/zoom)
									});
									delete res;
								}
							});
						}else{
							customdesign.fn.preset_import(ops, {
								left: (((e.clientX - rect.left)/zoom) - disc.x)-(view[4]/zoom),
								top: (((e.clientY - rect.top)/zoom) - disc.y)-(view[5]/zoom)
							});
						}
		
					}],
					['mousewheel', function(e){
	
						var zoom = parseFloat(customdesign.get.el('zoom').val());
		
						if (e.shiftKey) {
		
							zoom +=  e.wheelDelta*0.15;
		
							if (zoom < 100)
								zoom = 100;
							else if (zoom > 250)
								zoom = 250;
		
							customdesign.get.el('zoom').val(zoom).trigger('input');
							e.preventDefault();

						} else {
							
							if (customdesign.stage().canvas.isDrawingMode === true) {
								
								var range = customdesign.get.el('drawing-width'),
									val = parseFloat(range.val())+(e.wheelDelta*0.1);
									
								range.val(val).trigger('input');

								e.preventDefault();
								
							} else {
								
								var rel = {
										x: 0,
										y: (e.wheelDeltaY !== undefined ? e.wheelDeltaY*0.25 : e.wheelDelta*0.25)
									},
									canvas = customdesign.stage().canvas,
									view = canvas.viewportTransform;
			
					       		if (
					       			(view[5] > 0 && rel.y > 0) ||
					       			(view[5] < -((canvas.height*view[0]) - canvas.height) && rel.y < 0) ||
					       			zoom === 100
					       		) {
						       		rel.y = 0;
					       		} else {
					       			e.preventDefault();
						   		};
			
								canvas.relativePan(rel);
								return true;
							}
							
						}
		
		
					}],
					['dblclick', function(e) {
						var actv = stage.canvas.getActiveObject();
						if (actv && actv.type == 'i-text')
							customdesign.get.el('text-tools li[data-tool="spacing"]').trigger('click').find('textarea.customdesign-edit-text').focus();
					}]
				].map(function(ev){
					wrp.addEventListener(ev[0], ev[1], false);
				});
	
				stage.canvas.backgroundColor = '#ebeced';
				
				stage.canvas.on(customdesign.objects.events);
				
				/*
				*	Add product base
				*/
				
				var product = new fabric.Image(img);
		
				stage.product = product;

				customdesign.f(false);
				
				if (product.width > mw) {
					product.height = product.height*(mw/product.width);
					product.width = mw;
				};
				
				if (product.height > mh) {
					product.width = product.width*(mh/product.height);
					product.height = mh;
				};
				
				
				var ph = stage.canvas.height*0.9,
					pw = (product.width*(stage.canvas.height/product.height))*0.9;
				
				if (product.height <= stage.canvas.height*0.9) {
					ph = product.height;
					pw = product.width;
				};
				
				product.set({
					left: stage.canvas.width/2,
					top: (stage.canvas.height-40)/2,
					width: pw,
					height: ph,
					selectable: false,
					evented: false,
				});
				/*
				*	Cache for large product image
				*/
				if (
					product.full_src === undefined &&
					(
						img.naturalWidth > pw || 
						img.naturalHeight > ph
					)
				) {
					
					var canvas = document.createElement('canvas'),
						ctx = canvas.getContext('2d'),
						type = customdesign.fn.get_type(img.src);
					
					canvas.width = img.naturalWidth;
					canvas.height = img.naturalHeight;
					
					ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);
					
					product.set({full_src: canvas.toDataURL('image/'+type)});
					
					ctx.clearRect(0, 0, img.naturalWidth, img.naturalHeight);
					
					canvas.width = pw;
					canvas.height = ph;
					
					ctx.drawImage(img, 0, 0, pw, ph);
					
					product.setSrc(canvas.toDataURL('image/'+type), function() {});
					
					delete canvas;
					delete ctx;
					
				};
				
				/*
				*	Add product color
				*/
				
				var color = customdesign.get.color();
				
				stage.productColor = new fabric.Rect({
					width: pw-2,
					height: ph-2,
					left: (stage.canvas.width/2),
					top: ((stage.canvas.height-40)/2),
					fill: color,
					/*stroke: '#ebeced',
					strokeWidth: 2,*/
					selectable: false,
					evented: false,
					stroke: 'transparent'
				});
				
				var ez_ratio = stage.product_width ? pw/stage.product_width : 1,
					editing = {
						width: stage.edit_zone.width*ez_ratio,
						height:  stage.edit_zone.height*ez_ratio,
						top: (stage.edit_zone.top*ez_ratio)+(((stage.canvas.height-40)/2)-(ph/2)),
						left: stage.edit_zone.left*ez_ratio
					};
				
				var radius = (stage.edit_zone.radius !== undefined && stage.edit_zone.radius !== '') ? 
							 stage.edit_zone.radius : 0;
				
				radius = (radius * editing.width)/100;	
				
				stage.limit_zone = new fabric.Rect({
					fill: 'transparent',
					left: ((stage.canvas.width/2)+editing.left) - (editing.width/2),
					top: (((ph/2)+editing.top) - (editing.height/2)),
					height: editing.height,
					width: editing.width,
					originX: 'left',
					originY: 'top',
					stroke: customdesign.fn.invert(color),
					strokeDashArray: stage.crop_marks_bleed ? [0, 0] : [5, 5],
					selectable: false,
					evented: false,
					visible: false,
					radius: radius,
					rx: radius,
					ry: radius,
				});
				
				if (stage.overlay) {
					stage.canvas.setOverlayImage(product);
					stage.canvas.add(stage.productColor, stage.limit_zone);
				} else { 
					stage.canvas.add(stage.productColor, product, stage.limit_zone);
				};
				
				if (stage.crop_marks_bleed) {
					stage.bleed = new fabric.Rect({
						fill: 'transparent',
						left: ((stage.canvas.width/2)+editing.left) - (editing.width/2)+5,
						top: (((ph/2)+editing.top) - (editing.height/2))+5,
						height: editing.height-10,
						width: editing.width-10,
						originX: 'left',
						originY: 'top',
						stroke: customdesign.fn.invert(color),
						strokeDashArray: [5, 5],
						selectable: false,
						evented: false,
						visible: false,
						radius: radius,
						rx: radius,
						ry: radius,
					});
					stage.crop_marks = new fabric.Rect({
						fill: 'transparent',
						left: ((stage.canvas.width/2)+editing.left) - (editing.width/2)-5,
						top: (((ph/2)+editing.top) - (editing.height/2))-5,
						height: editing.height+5,
						width: editing.width+5,
						originX: 'left',
						originY: 'top',
						stroke: '#ff000038',
						strokeWidth: 5,
						strokeDashArray: [0, 0],
						selectable: false,
						evented: false,
						visible: false,
						radius: radius,
						rx: radius,
						ry: radius,
					});
					stage.canvas.add(stage.bleed, stage.crop_marks);
				};
				
				if (customdesign.data.auto_fit == '1' && $(window).width() > 1024) {
					
					var zoom = 1;
					
					if (ph < mh) {
						zoom = (mh/ph);
						if (zoom*pw > mw)
							zoom = (mw/pw);
					};
					
					if (pw < mw && zoom < mw/pw) {
						zoom = (mw/pw);
						if (zoom*ph > mh)
							zoom = (mh/ph);
					};
					
					if (zoom*98 > 100) {		
						$('#customdesign-zoom').
							val(zoom*98).
							attr({'data-value': parseInt(zoom*98)+'%'}).
							parent().
							attr({'data-value': parseInt(zoom*98)+'%'});
						
						stage.canvas.zoomToPoint(
							new fabric.Point(
								(mw/2),
								((mh-40)/2)
							), 
							zoom*0.98
						)
					}
						
				};
				
				customdesign.mobile(true);
					
			},
			
			stage_nav : function(name, ty) {
				
				var nav = customdesign.get.el('stage-nav'),
					ww = customdesign.ops.window_width;	
				
				if (name !== undefined) {
					nav.attr({'data-name': name});
					if (ty !== undefined)
						nav.attr({'data-pos': 'right', 'data-ty': ty});
				} else name = nav.attr('data-name');
				
				nav.find('li.active').removeClass('active');
				nav.find('li[data-stage="'+name+'"]').addClass('active');
				
				var nex = nav.find('li.active').nextAll('li[data-stage]'),
					pre = nav.find('li.active').prevAll('li[data-stage]');
				
				if (nex.length > 0)
					nav.find('li[data-nav="next"]').removeClass('disbl').find('span').html(
						nex.first().find('p, span').text()
					);
				else nav.find('li[data-nav="next"]').addClass('disbl');
				
				if (pre.length > 0)
					nav.find('li[data-nav="prev"]').removeClass('disbl').find('span').html(
						pre.first().find('p, span').text()
					);
				else nav.find('li[data-nav="prev"]').addClass('disbl');
			
			},
			
			process_variations : function(values, el) {
				// hash : b7384613351cb126e25f6d2de13b0224
				customdesign.cart.printing.current = null;

				let stages = customdesign.ops.product_data.stages,
					vari_data = {
						variation	: null,
						name		: customdesign.ops.product_data.name,
						sku		: customdesign.ops.product_data.sku,
						description	: customdesign.ops.product_data.description,
						price		: customdesign.ops.product_data.price,
						printings	: $.extend(true, [], customdesign.ops.product_data.printings),
						attributes	: $.extend(true, {}, customdesign.ops.product_data.attributes),
						stages		: $.extend(true, {}, stages.stages ? stages.stages : stages),
						printing	: customdesign.cart.printing.current // active print, if not the first will be actived
					};
				
				// Set default form values	
				if (values !== null && typeof values == 'object') {
					Object.keys(values).map(function(k) {
						if (values[k] !== undefined && typeof values[k].trim == 'function')
							values[k] = values[k].trim();
						if (vari_data.attributes[k] !== undefined) {
							vari_data.attributes[k].value = values[k];
						} else if (k == 'printing') {
							vari_data.printing = values[k];
						}
					});
				}
				
				// if there are no variations
				if (
					typeof customdesign.data.variations != 'object' || 
					customdesign.data.variations.variations === undefined ||
					Object.keys(customdesign.data.variations.variations).length === 0
				) 
					return vari_data;
				
				// Get matched variation
					
				let obj = null, 
					varis = customdesign.data.variations;
				
				// Keep options of current trigger element
				
				varis.attrs.map(function(a) {
					vari_data.attributes[a].allows = [];
					if (el !== null && el !== undefined && a == el.name) {
						vari_data.attributes[a].allows = customdesign.ops.product_data.attributes[a].allows;
						vari_data.attributes[a].value = values[el.name];
					}
				});
				
				// Only show options of other attributes match with trigger_id 
				
				Object.keys(varis.variations).map(function(v) {
					
					let valid = true;
					
					Object.keys(varis.variations[v].conditions).map(function(c) {
						
						// Collect all match option value of OTHER attributes
						
						if (vari_data.attributes[c].allows === undefined)
							vari_data.attributes[c].allows = [''];
							
						if (
							el !== null && 
							el !== undefined && 
							c != el.name &&
							(
								varis.variations[v].conditions[el.name] == '' || // condition attr c is any
								values[el.name] == '' || // trigger is any
								varis.variations[v].conditions[el.name] == values[el.name]
								// condition attr c match with trigger
							) &&
							vari_data.attributes[c].allows.indexOf(varis.variations[v].conditions[c]) === -1
						) {
							
							if (varis.variations[v].conditions[c] !== '')
								vari_data.attributes[c].allows.push(varis.variations[v].conditions[c]);
							else if (
								typeof vari_data.attributes[c].values == 'object' &&
								typeof vari_data.attributes[c].values.options == 'object'
							){
								// if condition of variation is any, set allow all options of attr
								
								vari_data.attributes[c].values.options.map(function(op) {
									if (vari_data.attributes[c].allows.indexOf(op.value) === -1)
										vari_data.attributes[c].allows.push(op.value);
								});
							}
							
							if (values[c] == varis.variations[v].conditions[c])
								vari_data.attributes[c].value = values[c];
								
						} else if (el === null || el === undefined) {
							
							if (varis.variations[v].conditions[c] == '') {
								
								vari_data.attributes[c].allows = [''];
								
								if (
									typeof vari_data.attributes[c].values == 'object' &&
									typeof vari_data.attributes[c].values.options == 'object'
								){
									vari_data.attributes[c].values.options.map(function(op) {
										if (vari_data.attributes[c].allows.indexOf(op.value) === -1)
											vari_data.attributes[c].allows.push(op.value);
									});
								}
							} else if (vari_data.attributes[c].allows.indexOf(varis.variations[v].conditions[c]) === -1)
								vari_data.attributes[c].allows.push(varis.variations[v].conditions[c]);
						}
						
						// Check valid variation
						
						if (
							varis.variations[v].conditions[c] !== '' &&
							(
								values[c] === undefined ||
								varis.variations[v].conditions[c] != values[c]
							)
						) valid = false;
					});
					
					// Valid first variation
					
					if (valid && obj === null) {
						obj = varis.variations[v];
						obj.id = v;
					}
					
				});
				
				// Found a variation matchs with attribute values selected
				
				if (obj !== null) {
					
					['price', 'sku', 'description', 'minqty', 'maxqty'].map(function(p) {
						if (obj[p] !== undefined && obj[p] !== null && obj[p] !== '')
							vari_data[p] = obj[p];
					});
					
					if (
						obj['cfgprinting'] === true &&
						obj['printings'] !== undefined && 
						obj['printings'] !== null && 
						obj['printings'] !== ''
					) {
						obj['printings'].map(function(p) {
							if (p['calculate'] && typeof p['calculate'] == 'string')
								p['calculate'] = customdesign.fn.dejson(p['calculate']);
						});
						vari_data['printings'] = $.extend(true, [], obj['printings']);
						vari_data['printings_cfg'] = obj['printings_cfg'];
						vari_data['cfgprinting'] = true;
					};
					
					if (
						obj['cfgstages'] === true && 
						obj['stages'] !== undefined && 
						obj['stages'] !== null && 
						obj['stages'] !== ''
					) {
						vari_data['stages'] = $.extend(true, {}, obj['stages']);
						vari_data['cfgstages'] = true;
					};
					
					vari_data.variation = obj.id;
					
				}
				
				return vari_data;
				
			},
			
			keep_current_designs : function(new_stages) {
				
				if (customdesign.ops.first_completed === false)
					return new_stages;
					
				var curent_designs = customdesign.fn.export().stages;
				
				Object.keys(curent_designs).map(function(c, i) {
					if (typeof curent_designs[c].data == 'string')
						curent_designs[c].data = JSON.parse(curent_designs[c].data);
					customdesign.ops.session_designs[i] = curent_designs[c].data;
				});
				
				Object.keys(new_stages).map(function(s, i) {
					if (customdesign.ops.session_designs[i] !== undefined) {
						new_stages[s].data = customdesign.ops.session_designs[i];
					}
				});
				
				return new_stages;
				
			},
			
			preview_designs : function() {
				
				customdesign.get.el('stage-nav').addClass('stages-expand preview-designs')
			},
			
			print_detail : function(id) {
				
				var table_content = qkey = '', qkeys = [], qkeyind,
					print = customdesign.data.printings.filter(function (print){
						if(print.id == id)
							return print;
					})[0];
				
				customdesign.tools.lightbox({
					content: '<div class="customdesign_content customdesign_wrapper_table">\
								<h3 class="title">'+customdesign.i(67)+' ('+print.title+')</h3>\
								<div id="customdesign-print-detail">\
									<i class="customdesign-spinner x3 margin-2"></i>\
								</div>\
							</div>'
				});
				
				$('#customdesign-print-detail').html((print.description !== '' ? '<div>'+print.description+'</div><br>' : ''));
				
				if (typeof print.calculate == 'string')
					print.calculate = customdesign.fn.dejson(print.calculate);
				
				var tab_nav = '<ul class="customdesign_tab_nav ' + ((print.calculate.multi) ? '': 'hidden') +'">';
				
				if (print.calculate !== undefined && print.calculate.show_detail == '1') {
					
					var j	= 1, 
						fi	= Object.keys(print.calculate.values)[0];
						
					for (var i in print.calculate.values){
						
						if (print.calculate.multi) {
							tab_nav += '<li class=><a href="#" data-side="'+i+'">'+customdesign.i('stage')+' '+(j++)+'</a></li>';
							table_content += '<div class="customdesign_tab_content" data-customdesign-tab="'+i+'">'
						};

						table_content += '<table>\
								<thead>\
									<tr>\
										<th>'+customdesign.i(66)+'</th>';
													
						for (var r in 
							print.calculate.values[fi][Object.keys(print.calculate.values[fi])[0]]
						) {
								table_content += '<th>'+decodeURIComponent(r)+'</th>';
						};
						
						table_content += '</tr></thead><tbody>';
						
						qkeys = Object.keys(print.calculate.values[i]);
						
						for (var r in print.calculate.values[i]){
							qkeyind = qkeys.indexOf(r);
							
							qkey = (typeof qkeys[qkeyind-1] !== 'undefined') ? 
								((r.indexOf('>') > -1)? r : 
								(parseInt(qkeys[qkeyind-1]) + 1) + ' - ' + r) : 
								'0' + ' - ' +r;
							
							table_content += '<tr><td>'+qkey+'</td>';

							for (var td in print.calculate.values[i][r]) {
								table_content += '<td>' +
									((print.calculate.values[i][r][td]*1>0) ? 
									customdesign.fn.price(print.calculate.values[i][r][td]) :
									customdesign.i(100))+ '</td>';
							};	
							table_content += '</tr>';
						};

						table_content += '\
							</tbody>\
							</table>';

						if (print.calculate.multi)
							table_content += '</div>';

					};
					
					tab_nav += '</ul>';
					
					var elm = $('#customdesign-print-detail');
					
					elm.append(tab_nav+table_content);

					customdesign.trigger({
						el : elm,
						events : {
							'.customdesign_tab_nav a:click' : 'active_tab'
						},
						active_tab : function (e){
							
							e.preventDefault();
							
							elm.find('li').removeClass('active');
							elm.find('[data-customdesign-tab]').removeClass('active');
							$(this).closest('li').addClass('active');
							elm.find('[data-customdesign-tab=' +$(this).
								addClass('active').data('side')+ ']').
								addClass('active');
						}
					});
					
					elm.find('.customdesign_tab_nav a:first').trigger('click');
					
				}
				
			},
			
			edit_design : function(ops) {
				
				customdesign.tools.save();
				customdesign.tools.clearAll();
				
				Object.keys(customdesign.data.stages).map((s, i) => {
					
					if (
						Object.keys(ops.stages)[i] !== undefined &&
						ops.stages[Object.keys(ops.stages)[i]].data !== undefined
					) {
						customdesign.data.stages[s].data = ops.stages[Object.keys(ops.stages)[i]].data;
					}
					
				});
				
				customdesign.active_stage(customdesign.render.stage_nav());
				customdesign.fn.navigation('clear');
				
			},
						
			load_product : function(ops) {
				
				customdesign.f(customdesign.i('loading'));
				
				var product = null;
					donow = function(res) {
						
						if (res === null || res === undefined) {
							customdesign.f(false);
							customdesign.actions.do('noproduct');
							return;
						};
							
						if (typeof res.variations == 'string' && res.variations !== '')
							res.variations = customdesign.fn.dejson(res.variations);
						else res.variations = {};
						
						if (typeof res.attributes == 'string' && res.attributes !== '')
							res.attributes = customdesign.fn.dejson(res.attributes);
						else res.attributes = {};
						
						if (typeof res.stages == 'string')
							res.stages = customdesign.fn.dejson(res.stages);
							
						res.variations.default = ops.options;
						
						if (ops.printing)
							res.variations.default.printing = ops.printing;
						
						if (res.variations.variations) {
							Object.keys(res.variations.variations).map(function(v) {
								res.variations.variations[v].printings.map(function(p) {
									if (typeof p.calculate == 'string')
										p.calculate = customdesign.fn.dejson(p.calculate);
								})
							});
						};
						
						if (typeof ops.template == 'object') {
							customdesign.cart.template = ops.template.stages;
							customdesign.cart.price.template = ops.template.price;
							res.template = ops.template;
						};
						
						res.saved_stages = ops.stages;
						
						customdesign.render.product(res, function() {
							if (customdesign.ops.first_completed !== true) {
								customdesign.actions.do('first-completed');
								customdesign.ops.first_completed = true;
							};
							customdesign.fn.update_state();
						});
						
						if (typeof ops.callback == 'function')		
							ops.callback(res);
						
					};
				
				if (
					customdesign.ops.products !== undefined && 
					typeof customdesign.ops.products.products == 'object'
				)
					product = customdesign.ops.products.products.filter(function(p) {return p.id == ops.id;});
				
				if (product !== null && product.length > 0)
					return donow(product[0]);
				
				customdesign.post({
					action: 'load_product',
					id: ops.id
				}, donow);
				
			},
			
			export : function(save, id, created, name) {
			
				// Editing design before add to cart
				var data = {
						stages : {},
						type : customdesign.data.type,
						extra : customdesign.cart.price.extra,
						updated: new Date().getTime()/1000,
						name : customdesign.get.el('product header name t').text().trim(),
						id: customdesign.ops.product_data.id,
						system_version: customdesign.data.version
					},
					thumbn = {
						screenshot: '',
						stages: 0,
						name: data.name,
						updated: data.updated,
						id: data.id,
						system_version: customdesign.data.version 
					};
				
				if (created !== undefined) {
					data.created = created;
					thumbn.created = created;
				};
				
				customdesign.get.el('stage-nav').find('li[data-stage]').each(function(i){

					var s = this.getAttribute('data-stage'),
						stage = customdesign.data.stages[s];

					if (!stage)
						return;
					
					if (stage.canvas) {
						
						var view_port = stage.canvas.viewportTransform;
						
						stage.canvas.set('viewportTransform', [1, 0, 0, 1, 0, 0]);
						
						data.stages[s] = {
							data : customdesign.tools.export(stage),
							screenshot: customdesign.tools.toImage({
								stage: stage,
								//is_bg: (save == 'cart' || save == 'share') ? 'full' : false, 
								is_bg: 'full', 
								multiplier: 1/window.devicePixelRatio
							}),
							edit_zone: stage.edit_zone,
							image: stage.image,
							overlay: stage.overlay,
							updated: data.updated,
							product_width: stage.product_width !== undefined ? stage.product_width : stage.product.width,
							product_height: stage.product_height !== undefined ? stage.product_height : stage.product.height,
							devicePixelRatio: window.devicePixelRatio
						};
						
						customdesign.data.stages[s].screenshot = data.stages[s].screenshot;
						
						stage.canvas.set('viewportTransform', view_port);
						stage.canvas.renderAll();
							
					}else {
						
						data.stages[s] = {
							data : stage.data,
							screenshot: stage.screenshot,
							edit_zone: stage.edit_zone,
							image: stage.image,
							overlay: stage.overlay,
							updated: data.updated
						};
						
					};
					
					thumbn.stages++;
					
					if (thumbn.screenshot === '')
						thumbn.screenshot = stage.screenshot;
					
				});
				
				if (
					customdesign.ops.first_completed === true && 
					customdesign.fn.url_var('order_print', '') === '' &&
					(save === true || save == 'designs' || save == 'share' || typeof save == 'function')
				) {
					
					//store template info before save
					data['template'] = {
						'stages' : customdesign.cart.template,
						'price' : customdesign.cart.price.template
					};
					
					if (customdesign.fn.url_var('cart', '') !== '') {
						
						customdesign.actions.do('cart-changed', data);
						
						/*
							// Auto save design of cart item editting
							data.id = cart_id;
							customdesign.indexed.save([data], 'cart');
						*/
					}
					else if (save == 'share') {
						return data;
			    	}
		    		else if (typeof save == 'function') {
			    		save(data, thumbn);
			    	}
		    		
		    		if (
		    			save == 'designs' && customdesign.ops.importing !== true
		    		) {
			    		
						var design_id = (id !== undefined && id !== null && id != 'new') ? 
										id : 
										new Date().getTime().toString(36).toUpperCase(),
							product_id = customdesign.fn.url_var('product_base', '');
							product_cms = customdesign.fn.url_var('product_cms', '');
						
						data.id = design_id;
						
						thumbn = $.extend(true, thumbn, {
							id : design_id,
							product : product_id,
							product_cms : product_cms,
							product_cms : product_cms,
							printing : customdesign.cart.printing.current,
							options: customdesign.cart.data.options,
							template: {
								'stages' : customdesign.cart.template,
								'price' : customdesign.cart.price.template
							}
						});
						
						if (created !== undefined) {
							thumbn.created = created;
							data.created = created;
						};
						
						if (name !== undefined) {
							thumbn.name = name;
							data.name = name;
						};
						
						try {
							customdesign.indexed.save([thumbn, data], 'designs', function(){
								delete data;
								delete thumbn;
								customdesign.actions.do('save-design', design_id);
							});
						}catch (ex){console.log(ex);}
						
						delete customdesign.ops.designs_loading;
						delete customdesign.ops.designs_cursor;
						
					} 
					
		    		delete data;
		    		delete thumbn;
			    	
				};

				return data;

			},

			set_url : function(name, val) {

				var url = window.location.href;

				url = url.split('#')[0].replace(/\,/g, '').split('?');

				if (url[1]) {

					var ur = {};

					url[1].split('&').map(function(s){
						s = s.split('=');
						ur[s[0]] = s[1];
					});

					url[1] = [];

					if (val === null)
						delete ur[name];
					else ur[name] = val;

					Object.keys(ur).map(function(s){
						url[1].push(s+'='+ur[s]);
					});

					url = url[0]+'?'+url[1].join('&');

				}else if(val !== null) url = url[0]+'?'+name+'='+val;


				window.history.replaceState({}, "", url);

			},

			url_var : function(name, def) {

				var url = window.location.href.split('#')[0].split('?'),
					result = def;

				if (!url[1])
					return def;

				url[1].split('&').map(function(pam){
					pam = pam.split('=');
					if (pam[0] == name)
						result = pam[1];
				});

				return result;

			},
			
			get_url : function(name, def) {
				return this.url_var(name, def);	
			},
			
			attr_label : function(key, attrs) {
				
				if (typeof attrs == 'object' && typeof attrs.filter == 'function') {
					
					var label = attrs.filter(function(a) {
						return a.value == key;
					});
					
					if (label.length > 0 && label[0].label !== undefined)
						return label[0].label;
					else return key;
					
				} else return key;
	
			},
			
			date : function(f, t){
				
				if (t === undefined || t === '')
					return '';
				
				if (typeof t == 'string' && (t.indexOf('-') > -1 || t.indexOf(':') > -1))
					t = new Date(t);
				else if (t.toString().split('.')[0].length === 10)
					t = new Date(parseFloat(t)*1000);
				else t = new Date(parseFloat(t));

				var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
					days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
					map = {
						't': (t.getMonth() < 10 ? '0' : '')+(t.getMonth()+1),
						'h': t.getHours(),
						'm': (t.getMinutes() < 10? '0' : '') + t.getMinutes(),
						'd': t.getDate(),
						'D': days[t.getDay()],
						'M': months[t.getMonth()],
						'y': t.getYear(),
						'Y': t.getFullYear(),
					};
					str = '';


				f.split('').map(function(s){
					str += map[s] != undefined ? map[s] : s;
				});

				return str;

			},

			cart_thumbn : function(id) {
                
                customdesign.indexed.get(id, 'cart', function(res){
                    
                    if (res === null || res === undefined)
                        return;
                    var objs = Object.keys(res.stages);
                    for(var i=0; i< objs.length; i++)
                    {
                        var stage = res.stages[objs[i]];
                        var ratio = 180/stage.product_height;
                        img = '<img data-view="layer" style="height: 180px;width: '+(stage.product_width*ratio)+'px; '+(i>0 ? "display:none;":"")+'" src="'+stage.screenshot+'" />';
                        $('div[data-design-layer="'+id+'"]').append(img);
                    }
                    
                     
                    
                });
            },
			
			get_type : function(src) {
				
				if (src.indexOf('data:image/jpeg') > -1)
					return 'jpeg';
				else if (src.indexOf('data:image/png') > -1)
					return 'png';
				else if (src.indexOf('data:image/svg') > -1)
					return 'svg';
				if (src.split('.').pop() == 'jpg')
					return 'jpeg';
				else if (src.split('.').pop() == 'png')
					return 'png';
				else if (src.split('.').pop() == 'svg')
					return 'svg';
				
				return 'jpeg';
				
			},
			
			scale_designs : function(scale, pos) {
				
				if (scale === 0)
					return;
					
				var stage = customdesign.stage(),
					canvas = stage.canvas,
					bd = stage.limit_zone.strokeWidth*2,
					objs = canvas.getObjects().filter(function(o) {
						if (o.evented === true) {
							o.set('active', true);
							return true;
						} else return false;
					});
					
				if (objs.length === 0) {
					//e.preventDefault();
					return false;
				};
				
				scale = scale*(stage.limit_zone.width/(stage.limit_zone.width-bd));
				
				var group = new fabric.Group(objs, {
					scaleX: scale,
					scaleY: scale,
					originX: 'center',
					originY: 'center'
				});
				
				var xl = ((stage.limit_zone.width-bd)/2)+stage.limit_zone.left,
					yl = ((stage.limit_zone.height-bd)/2)+stage.limit_zone.top,
					left = xl-((xl - group.left)*scale),
					top = yl-((yl - group.top)*scale);
				
				if (pos !== undefined) {
					if (pos.left !== undefined) {	
						left = bd+stage.limit_zone.left+((group.width/2)*scale);
						left += pos.left;
					}
					if (pos.top !== undefined) {	
						top = bd+stage.limit_zone.top+((group.height/2)*scale);
						top += pos.top;
					}
				}
				
				group.set({
					left: left,
					top: top
				});
				
				canvas._activeObject = null;
				
				canvas.setActiveGroup(group.setCoords()).renderAll();
				
				customdesign.tools.discard();
				
			},
			
			font_blob : function(obj) {
				
				if (typeof obj.font == 'string' && obj.font.trim().indexOf('data:') === -1) {

					if (obj.font.indexOf('http') === -1)
						obj.font = customdesign.data.upload_url+obj.font;
					
					customdesign.fn.get_blob(obj.font, function() {
						obj.set('font', this.result);
						customdesign.tools.save();
					});

				}
			
			},
			
			clear_url: function(ex) {
				
				['car', 'design_print', 'order_print', 'design', 'share'].map(function(i) {
					if (typeof ex !== 'object' || ex.indexOf(i) === -1)
						customdesign.fn.set_url(i, null);
				});
				
			},
			
			do_double: function() {
				
				var canvas = customdesign.stage().canvas,
					active = canvas.getActiveObject(),
					group = canvas.getActiveGroup(),
					do_clone = function(ids) {
						
						var clones = [];
						canvas.getObjects().map(function(obj){
							
							if (!obj.id || ids.indexOf(obj.id) === -1)
								return;
							
							var clone = obj.toJSON();
							delete clone.toClip;
							customdesign.ops.export_list.map(function(l){
								clone[l] = obj[l];
							});
							
							clone.left = ((group ? group.left : 1)+obj.left)*1.1;
							clone.top = ((group ? group.top : 1)+obj.top)*1.1;
							clone.thumbn = obj.thumbn;
							clone.replace = false;
							clone.id = parseInt(new Date().getTime()/1000).toString(36)+'-'+Math.random().toString(36).substr(2);
							
							clones.push(clone);
							
						});
						
						customdesign.tools.import ({objects: clones}, function(){});
						
					};
					
				if (active) {
					
					if (
						active.imagebox !== undefined &&
						active.imagebox !== '' &&
						canvas.getObjects().filter(function(o) {return o.id == active.imagebox;}).length > 0
					) return;
					
					customdesign.tools.discard();
					clearTimeout(customdesign.ops.preventDbl);
					customdesign.ops.preventDbl = setTimeout(do_clone, 100, [active.id]);

				}else if(group){
					
					return;
					
					var ids = [];
					group._objects.map(function(o){
						if (o.id && ids.indexOf(o.id) === -1)
							ids.push(o.id);
					});
					
					customdesign.tools.discard();
					do_clone(ids);
					
					return true;
					// && confirm(customdesign.i('05'))
					var clones = [];
						
					group._objects.map(function(obj){
						delete obj.clipTo;
						clones.push(obj.clone() ? obj.clone() : obj);
					});
					
					var new_group = new fabric.Group(clones, {
						left: group.left,
						top: group.top,
						scaleX: group.scaleX*5,
						scaleY: group.scaleY*5,
					});

					var ops = {
							left: group.left,
							top: group.top,
							height: group.height,
							width: group.width,
							scaleX: group.scaleX,
							scaleY: group.scaleY,
							angle: group.angle,
							name: 'Group objects',
							text: 'Group objects',
							src: new_group.toDataURL()
						};

					new_group.set('scaleX', new_group.scaleX/5);
					new_group.set('scaleY', new_group.scaleY/5);

					customdesign.objects.customdesign.image(ops, function(obj){

						var index = canvas.getObjects().indexOf(group._objects[0]);

						customdesign.stage().canvas.discardActiveGroup();

						group._objects.map(function(c){
							canvas.remove(c);
						});

						canvas.add(obj);
						obj.moveTo(index);

						customdesign.stack.save();
						customdesign.design.layers.build();

					});

				}
	
			},
			
			build_lumi: function(img) {
		
				var s = customdesign.stage(),
					cv = document.createElement('canvas'),
					ctx = cv.getContext('2d'),
					w = 200,
					h = 200*(img.naturalHeight/img.naturalWidth),
					time = new Date().getTime();
				
				cv.height = img.naturalHeight;
				cv.width = img.naturalWidth;
				
				ctx.drawImage(img, 0, 0, cv.width, cv.height);
					
				var urldata = cv.toDataURL('image/'+(img.src.indexOf('.png') > -1 ? 'png' : 'jpeg')),
					data = {"stages":{"customdesign":{"data":{"objects":[null,null,{"type":"image","originX":"center","originY":"center","left":(w/2)+2,"top":(h/2)+2,"width":w*0.9,"height":h*0.9,"fill":"rgb(0,0,0)","stroke":"","strokeWidth":0,"strokeLineCap":"butt","strokeLineJoin":"miter","strokeMiterLimit":10,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"visible":true,"backgroundColor":"","fillRule":"nonzero","globalCompositeOperation":"source-over","skewX":0,"skewY":0,"crossOrigin":"","alignX":"none","alignY":"none","meetOrSlice":"meet","src":urldata,"evented":true,"selectable":true,"filters":[],"resizeFilters":[]}],"background":"#ebeced","devicePixelRatio":2,"product_color":"#00ff7f","limit_zone":{"width":w,"height":h,"top":0,"left":0},"edit_zone":{"height":h,"width":w,"left":0,"top":0,"radius":"0"},"product_width":s.product.width,"product_height":s.product.height,"screenshot":""},"screenshot":"","edit_zone":{"height":h,"width":w,"left":0,"top":0,"radius":"0"},"updated":time,"padding":[0,0]}},"updated":time};
				
				delete urldata;
				delete cv;
				delete ctx;
				delete img;
				
				return encodeURIComponent(JSON.stringify(data));
				
				// return 'data:application/octet-stream;base64,'+btoa(encodeURIComponent(JSON.stringify(data)));
				
			},
			
			enjson : function(str) {
				return btoa(encodeURIComponent(JSON.stringify(str)));
			},
			
			dejson : function(str) {
				return JSON.parse(decodeURIComponent(atob(str)));
			},
			
			slugify : function(text) {
				
			  var a = 'àáạäâãấầẫậạăắằẵặèéëêếềễẹệìíĩïîịòóöôốồỗộọùúüûũụùúũđñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;',
			  	  b = 'aaaaaaaaaaaaaaaaeeeeeeeeeiiiiiiooooooooouuuuuuuuudncsyoarsnpwgnmuxzh------',
			  	  p = new RegExp(a.split('').join('|'), 'g');
			
			  return text.toString().toLowerCase()
					.replace(/\s+/g, '-')
					.replace(p, function(c) {return b.charAt(a.indexOf(c));}) 
					.replace(/&/g, '-and-')
					.replace(/[^\w\-]+/g, '')
					.replace(/\-\-+/g, '-')
					.replace(/^-+/, '')
					.replace(/-+$/, '');

			},
			
			pimage : function(stages) {
				
				for(var s in stages) {
					if (!stages[s].image) {
						stages[s].image = (
							stages[s].source == 'raws' ? 
							customdesign.data.assets+'raws/' : 
							customdesign.data.upload_url
						)+stages[s].url;
					}
				}
				
				return stages;
				
			},
			
			price : function(p) {
				let price = this.number_format(
					parseFloat(p*1),
					parseInt(customdesign.data.number_decimals),
					customdesign.data.decimal_separator,
					customdesign.data.thousand_separator,
				);
				return (customdesign.data.currency_position === '0' ? price+customdesign.data.currency : customdesign.data.currency+price);
			},
			
			number_format: function (number, decimals, dec_point, thousands_sep) {
			    // Strip all characters but numerical ones.
			    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
			    var n = !isFinite(+number) ? 0 : +number,
			        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
			        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
			        s = '',
			        toFixedFix = function (n, prec) {
			            var k = Math.pow(10, prec);
			            return '' + Math.round(n * k) / k;
			        };
			    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
			    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
			    if (s[0].length > 3) {
			        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
			    }
			    if ((s[1] || '').length < prec) {
			        s[1] = s[1] || '';
			        s[1] += new Array(prec - s[1].length + 1).join('0');
			    }
			    return s.join(dec);
			},
			
			distance : function(p1, p2) {
				
				var lat1 = p1.x,
					lon1 = p1.y,
					lat2 = p2.x,
					lon2 = p2.y;
				
				var deg2rad = function(deg) {
					return deg * (Math.PI/180);
				},
				dLat = deg2rad(lat2-lat1),
				dLon = deg2rad(lon2-lon1),
				a = Math.sin(dLat/2) * Math.sin(dLat/2) +
						Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
						Math.sin(dLon/2) * Math.sin(dLon/2); 
				
				return 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
			
			},
			
			confirm : function(opt) {
				
				var html = '<div id="customdesign-confirm"'+(opt.type !== undefined ? ' data-type="'+opt.type+'"' :'')+'>\
						<conf data-label="'+(opt.label ? opt.label : 'Confirmation')+'">\
							<p>'+opt.title+'</p>'+(opt.primary.text !== undefined ? 
							'<button class="customdesign-btn" data-btn="primary">'+
								opt.primary.text+(opt.primary.icon ? ' <i class="'+opt.primary.icon+'"></i>' : '')+
							'</button>' : '')+(opt.second.text !== undefined ? 
							'<button class="customdesign-btn white" data-btn="second">'+
								opt.second.text+(opt.second.icon ? ' <i class="'+opt.second.icon+'"></i>' : '')+
							'</button>' : '')+'\
							<i class="customdesignx-android-close" data-btn="close"></i>\
						</conf>\
					</div>';
					
				$('#customdesign-confirm').remove();
				$('#CustomdesignDesign').append(html);
				
				customdesign.trigger({
					el: $('#customdesign-confirm'),
					events: {
						'[data-btn="primary"]': function(e) {
							// hash : 5fecb5125fdb9c9cf8f2e54802cfb020
							if (typeof opt.primary.callback != 'function' || opt.primary.callback(e) !== false){
								if(sessionStorage.getItem("CUSTOMDESIGN-START-NEW") === null){
									sessionStorage.setItem('CUSTOMDESIGN-START-NEW', true);
								}
								$('#customdesign-confirm').remove();
							}
							e.preventDefault();
						},
						'[data-btn="second"]': function(e) {
							if (typeof opt.second.callback == 'function')
								opt.second.callback(e);
							$('#customdesign-confirm').remove();
							e.preventDefault();
						},
						'[data-btn="close"]': function(e) {
							$('#customdesign-confirm').remove();
							e.preventDefault();
						}
					}
				});
			},
			
			copy : function(text) {
				
				var input = document.createElement('input');
			    input.setAttribute('value', text.replace(/\&amp\;/g, '&'));
			    document.body.appendChild(input);
			    input.select();
			    document.execCommand('copy');
			    document.body.removeChild(input);
					
			},
			
			crop : function(ops) {
				
				customdesign.tools.lightbox({
					width: ops.width !== undefined ? ops.width : 500,
					content: '<div class="customdesign_crop_dragArea">\
								<img src="'+ops.src+'" class="customdesign_crop_img" style="max-height: 520px;" />\
								<div class="customdesign_crop_selArea">\
									<div class="customdesign_crop_marqueeHoriz customdesign_crop_marqueeNorth"><span></span></div>\
									<div class="customdesign_crop_marqueeVert customdesign_crop_marqueeEast"><span></span></div>\
									<div class="customdesign_crop_marqueeHoriz customdesign_crop_marqueeSouth"><span></span></div>\
									<div class="customdesign_crop_marqueeVert customdesign_crop_marqueeWest"><span></span></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleN" data-target="n"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleNE" data-target="ne"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleE" data-target="e"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleSE" data-target="se"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleS" data-target="s"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleSW" data-target="sw"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleW" data-target="w"></div>\
									<div class="customdesign_crop_handle customdesign_crop_handleNW" data-target="nw"></div>\
									<div class="customdesign_crop_clickArea" style="background-image: url(\''+ops.src+'\');" data-target="visible" title="Enter to apply">\
									</div>\
									<div class="customdesign_crop_info">0 x 0</div>\
								</div>\
								<div class="customdesign_crop_clickArea_scan" data-target="darken"></div>\
							</div>\
							<ul class="customdesign-crop-btns">\
								<li data-func="center">\
									<i class="customdesignx-resize-arrow-down"></i>\
									<span>'+customdesign.i('01')+'</span>\
								</li>\
								<li data-func="horizontal">\
									<i class="customdesignx-move-horizontal"></i>\
									<span>'+customdesign.i('02')+'</span>\
								</li>\
								<li data-func="vertical">\
									<i class="customdesignx-move-vertical"></i>\
									<span>'+customdesign.i('03')+'</span>\
								</li>\
								'+(ops.square !== false ? '<li data-func="square">\
									<i class="customdesignx-android-checkbox-outline-blank"></i>\
									<span>'+customdesign.i('04')+'</span>\
								</li>\
								' : '')+(ops.dimension !== undefined ? '<li data-func="dimension" class="active">\
									<i class="customdesignx-link"></i>\
									<span>'+customdesign.i('168')+'</span>\
								</li>\
								' : '')+'<li data-func="save">\
									'+customdesign.i('save')+'\
								</li>\
								<li data-func="cancel">\
									'+customdesign.i('cancel')+'\
								</li>\
							</ul>'
				});

				var crop = $('#customdesign-lightbox-content div.customdesign_crop_dragArea');
				
				crop.on('mousedown touchstart', function(e){
						
					if (e.type == 'touchstart') {
						e.clientX = e.originalEvent.pageX;
						e.clientY = e.originalEvent.pageY;
					}
					
					var wrp = $(this),
						lightbox = $('#customdesign-lightbox-content'),
						img = wrp.find('>img').get(0),
						el = wrp.find('.customdesign_crop_selArea'),
						i = wrp.find('.customdesign_crop_info'),
						c = wrp.find('.customdesign_crop_clickArea');

					var ratio = img.width/img.naturalWidth,
						target = e.target.getAttribute('data-target'),
						square = lightbox.find('li[data-func="square"]').hasClass('active'),
						lock_dimension = lightbox.find('li[data-func="dimension"]').hasClass('active'),
						dimension = ops.dimension !== undefined ? ops.dimension : 0; // width:height
						
					if (square && dimension === 0)
						dimension = 1;
					
					if (
						lightbox.find('li[data-func="dimension"]').length > 0 && 
						!lock_dimension
					) dimension = 0;
					
					crop.attr({'data-dimension': dimension});
						
					var _el = el.get(0),
						_o = {
							t: _el.offsetTop,
							l: _el.offsetLeft,
							h: _el.offsetHeight,
							w: _el.offsetWidth,
							ph: wrp.get(0).offsetHeight,
							pw: wrp.get(0).offsetWidth,
							pl: wrp.get(0).offsetLeft,
							pt: wrp.get(0).offsetTop,
							clientX: e.clientX,
							clientY: e.clientY
						};

					var dark_zone = function() {

						var o = {
							t: _el.offsetTop,
							l: _el.offsetLeft,
							h: _el.offsetHeight,
							w: _el.offsetWidth
						};
						
						c.css({
							backgroundPosition: ((-o.l)+'px '+(-o.t)+'px')
						});
						
						i.html(Math.round(o.w/ratio)+' x '+Math.round(o.h/ratio));

					};

					if (target == 'darken') {

						_o.l = e.clientX-$('#customdesign-lightbox-body').get(0).offsetLeft + (_o.pw/2);
						_o.t = e.clientY-$('#customdesign-lightbox-body').get(0).offsetTop + (_o.ph/2) + 23;

						el.css({
							left: _o.l+'px',
							top: _o.t+'px',
							width: '0px',
							height: '0px',
						});
					}

					dark_zone();

					$(this).on('mousemove touchmove', function(e){
						
						if (!target)
							return true;
						
						if (e.type == 'touchmove') {
							e.clientX = e.originalEvent.pageX;
							e.clientY = e.originalEvent.pageY;
						}
						
						var _l = _o.l + (e.clientX - _o.clientX),
							_t = _o.t + (e.clientY - _o.clientY),
							_w = _o.w + (e.clientX - _o.clientX),
							_h = _o.h + (e.clientY - _o.clientY);
							
						if (target == 'visible') {

								if (_l < 0){
									_l = 0;
									_o.clientX = e.clientX;
									_o.l = _l;
								}
								if (_t < 0){
									_t = 0;
									_o.clientY = e.clientY;
									_o.t = _t;
								}
								if (_l + _o.w > _o.pw){
									_l = _o.pw - _o.w;
									_o.clientX = e.clientX;
									_o.l = _l;
								}
								if (_t + _o.h > _o.ph){
									_t = _o.ph - _o.h;
									_o.clientY = e.clientY;
									_o.t = _t;
								}

								el.css({left: _l+'px', top: _t+'px'});
								
								dark_zone();

						}else if (target == 'darken'){

							_w = _w - _o.w;
							_h = _h - _o.h;

							if (_w < 0) {
								_w = -_w;
								el.css({left: _l+'px'});
							}

							if (_h < 0) {
								_h = -_h;
								el.css({top: _t+'px'});
							}

							if (dimension !== 0)
								_h = _w/dimension;

							el.css({width: _w+'px', height: _h+'px'});
							dark_zone();

						}else {

							if (['nw', 'ne', 'n'].indexOf(target) > -1) {
								el.css({top: _t+'px'});
								_h = _o.h - (e.clientY - _o.clientY);
							}

							if (['nw', 'sw', 'w'].indexOf(target) > -1) {
								el.css({left: _l+'px'});
								_w = _o.w - (e.clientX - _o.clientX);
							}

							if (['w', 'e', 'nw', 'ne', 'se', 'sw'].indexOf(target) > -1) {
								el.css({width: _w+'px'});
								if (dimension !== 0)
									el.css({height: (_w/dimension)+'px'});
							}

							if (['n', 's', 'nw', 'ne', 'se', 'sw'].indexOf(target) > -1) {
								el.css({height: _h+'px'});
								if (dimension !== 0)
									el.css({width: (_h*dimension)+'px'});
							}

							dark_zone();

						}
						
						e.preventDefault();
						
					});

				});

				crop.find('img.customdesign_crop_img').on('load', function(){

					var s = customdesign.get.stage(), lb = $('#customdesign-lightbox-content'), p;

					if (!s.active)
						return;
						
					if (!s.active.fx || !s.active.fx.crop) {
						p = {
							width: Math.round(this.offsetWidth*0.8)+'px',
							height: Math.round(this.offsetHeight*0.8)+'px',
							left: Math.round(this.offsetWidth*0.1)+'px',
							top: Math.round(this.offsetHeight*0.1)+'px',
						}
					} else {
						p = {
							width: (this.offsetWidth*s.active.fx.crop.width)+'px',
							height: (this.offsetHeight*s.active.fx.crop.height)+'px',
							left: (this.offsetWidth*s.active.fx.crop.left)+'px',
							top: (this.offsetHeight*s.active.fx.crop.top)+'px',
						}
					};
					
					if (ops.width === undefined && this.offsetWidth < 500)
						lb.css({'min-width': this.offsetWidth});
					
					lb.find('div.customdesign_crop_selArea').css(p);
					lb.find('div.customdesign_crop_dragArea').trigger('mousedown touchstart').off('mousemove');
					lb.find('div.customdesign_crop_clickArea').css({
						backgroundSize: this.offsetWidth+'px '+this.offsetHeight+'px',
						backgroundPosition: '-'+p.left+' -'+p.top,
						opacity: 1
					});
					
					crop.trigger('mousedown').off('mousemove touchmove');
					
					if (typeof ops.load == 'function')
						ops.load(this, crop);

				});

				$('#customdesign-lightbox-content .customdesign-crop-btns li[data-func]').on('click', function(e){

					var func = this.getAttribute('data-func'),
						el = crop.find('.customdesign_crop_selArea');

					switch (func) {
						case 'square' :

							if ($(this).hasClass('active'))
								return $(this).removeClass('active');
							else $(this).addClass('active');

							if (crop.width() > el.height())
								el.css({width: el.height()+'px'});
							else if (crop.height() > el.width())
								el.css({height: el.width()+'px'});

						break;
						case 'dimension' :

							if ($(this).hasClass('active'))
								return $(this).removeClass('active');
							else $(this).addClass('active');

						break;
						case 'center' :
							el.css({top: ((crop.height()/2)-(el.height()/2))+'px', left: ((crop.width()/2)-(el.width()/2))+'px'});
						break;
						case 'horizontal' :
							el.css({left: ((crop.width()/2)-(el.width()/2))+'px'});
						break;
						case 'vertical' :
							el.css({top: ((crop.height()/2)-(el.height()/2))+'px'});
						break;
						case 'save':
							
							if (typeof ops.save == 'function')
								ops.save(crop);
							
							return $('#customdesign-lightbox').remove();
							
						break;
						case 'cancel':
							return $('#customdesign-lightbox').remove();
						break;
					}

					$('#customdesign-lightbox-content div.customdesign_crop_dragArea').
						trigger('mousedown').
						off('mousemove').
						off('touchmove');

				});

				if (!customdesign.actions['globalMouseUp']) {
					
					customdesign.actions.add('globalMouseUp', function(e){
						
						if (document.querySelectorAll('#customdesign-lightbox-content .customdesign_crop_dragArea').length > 0) {
							
							var crop = $('#customdesign-lightbox-content div.customdesign_crop_dragArea'),
								area = crop.find('div.customdesign_crop_selArea'),
								w = area.width(),
								h = area.height(),
								l = area.get(0).offsetLeft,
								t = area.get(0).offsetTop,
								pw = area.parent().width(),
								ph = area.parent().height();
							
							if (
								w > pw ||
								w+l > pw
							) {
								area.css({
									width: (pw-l)+'px',
									height: (h*((pw-l)/w))+'px'
								});
							} else if (
								h > ph ||
								h+t > ph
							) {
								area.css({
									height: (ph-t)+'px',
									width: (w*((ph-t)/h))+'px'
								});
							};
							
							crop.trigger('mousedown').off('mousemove').off('touchmove');
							
						}
					});
				}
				
				return crop;
					
			},
			
			large_image_helper : function(op) {
				
				/*
					{
						w: img.naturalWidth,
						h: img.naturalHeight,
						ew: stage.limit_zone.width,
						eh: stage.limit_zone.height,
						iw: w,
						ih: h,
						el: img,
						obj: image,
						src: src
					}
				*/
				
				
				op.obj.set({full_src: op.src});
				
				
				var canvas = document.createElement('canvas'),
					ctx = canvas.getContext('2d');
				
				canvas.width = op.ew;
				canvas.height = op.ew*(op.h/op.w);
				
				if (canvas.height < op.eh) {
					canvas.height = op.eh;
					canvas.width = op.eh*(op.w/op.h);
				};
				
				ctx.drawImage(op.el, 0, 0, canvas.width, canvas.height);
				
				var src = canvas.toDataURL(
					'image/'+(op.src.indexOf('image/png') > -1 || op.src.indexOf('.png') > -1 ? 'png' : 'jpeg')
				);
				
				delete canvas;
				delete ctx;
				
				op.obj.setSrc(src, function() {
					
					op.obj.set({
						src: src,
						origin_src: src,
						width: op.iw, 
						height: op.ih
					});
					
					if (op.obj.fxOrigin) {
						op.obj.fxOrigin.onload = function() {
							customdesign.fn.refresh_image_fx(op.obj);
						};
						op.obj.fxOrigin.src = src;
					};
					
					customdesign.stage().canvas.renderAll();
						
					if (typeof op.callback == 'function')
						op.callback(src);
				});
				
				
			},
			
			uncache_large_images : function(callback, revert) {
				
				$('#CustomdesignDesign').attr({'data-processing': 'true', 'data-msg': 'Uncache processing..'});
				
				if (typeof callback != 'function')
					callback = function() {};
					
				var s = customdesign.stage(),
					objs = s.canvas.getObjects(),
					index = 0,
					process = function() {
						
						var obj = objs[index++];
						
						if (obj === undefined)
							return callback();
						
						if (obj.full_src !== undefined && obj.full_src !== '' && obj.type == 'image') {
							
							var w = obj.width, 
								h = obj.height, 
								old_src = obj.src;
							
							if (revert === true) {
								
								if (
									obj.old_src !== undefined && 
									obj.old_src !== null
								) {
									
									obj.setSrc(obj.old_src, function() {
										
										obj.set({
											width: w,
											height: h,
											old_src: null
										});
										
										customdesign.fn.refresh_image_fx(obj, process);
										
									});
								
								} else return process();
								
							} else{
								
								obj.setSrc(obj.full_src, function() {
									
									obj.set({
										width: w,
										height: h,
										old_src: old_src
									});
									
									customdesign.fn.refresh_image_fx(obj, process);
									
								});
								
							}
							
						} else process();
						
					};
				
				
				process();
				
					
			},
			
			calc_padding : function(stage) {
				
				stage.data.objects = stage.data.objects.filter(function(s){return s !== null;});
				
				if (stage.data.objects.length === 0)
					return [0, 0];
				
				var group = {};
				
				stage.data.objects.map((o) => {
					
					let w = (o.width+2)*o.scaleX,
						h = (o.height+2)*o.scaleY,
						l = o.left-(w/2),
						t = o.top-(h/2);
						
					if (group.width === undefined) {
						group = {
							width: w, 
							height: h, 
							left: l, 
							top: t
						}; return;	
					};
						
					if (l < group.left)
						group.left = l;
					if (t < group.top)
						group.top = t;
					if (l+w > group.left+group.width)
						group.width = l+w - group.left;
					if (t+h > group.top+group.height)
						group.height = t+h - group.top;
				});
				
				let res = [
					(group.left-stage.data.limit_zone.left)/stage.data.limit_zone.width,
					(group.top-stage.data.limit_zone.top)/stage.data.limit_zone.height
				];
				
				return res;
				
			},
			
			q : function(s, m) {
				return (m ? document.querySelectorAll(s) :  document.querySelector(s));
			}

		},

		render : {

			colorPresets : function() {
				
				var colors = customdesign.data.colors,
					el = $('.customdesign-color-presets'),
					lb;
				
				if (colors !== undefined && colors.indexOf(':') > -1)
					colors = colors.split(':')[1].replace(/\|/g, ',');
				
				if (customdesign.data.enable_colors != '0' && localStorage.getItem('customdesign_color_presets')) {
					colors = localStorage.getItem('customdesign_color_presets').replace(/\|/g, ',');
				};

				el.html('');

				colors.split(',').map(function(c){
					
					c = c.split('@'); lb = c[0];
						
					if (c[1] !== undefined && c[1] !== '')
						lb = decodeURIComponent(c[1]).replace(/\"/g, '');
					else if (customdesign.ops.color_maps[c[0]] !== undefined)
						lb = customdesign.ops.color_maps[c[0]];
						
					el.append('<li data-color="'+c[0]+'" title="'+lb+'" style="background:'+c[0]+'"></li>');
					
				});
				
				el.find('li').on('click', function(){
					var el = customdesign.get.el($(this).closest('ul.customdesign-color-presets').data('target'));
					el.val(this.getAttribute('data-color'));
					if (el.get(0).color && typeof el.get(0).color.fromString == 'function')
						el.get(0).color.fromString(this.getAttribute('data-color'));

				});
			1},

			refresh_my_designs : function(is_save){
				
				if (customdesign.ops.designs_loading === true)
					return;
					
				customdesign.get.el('saved-designs').html('');
				
				customdesign.ops.designs_loading = true;
				delete customdesign.ops.designs_cursor;
				customdesign.indexed.list(function(data){
					customdesign.render.my_designs(data);
					customdesign.ops.designs_cursor = data.id;
					delete data;
				}, 'designs', function(st){
					customdesign.ops.designs_loading = false;
					if (st == 'done') {
						$('#customdesign-my-designs').off('scroll');
						if (is_save) {
							$('#customdesign-saved-designs').prepend(
								'<li data-view="add" data-func="edit" data-id="new">\
									<b data-func="edit">+</b>\
									<span data-func="edit">'+customdesign.i(107)+'</span>\
								</li>'
							);
						} else if ($('#customdesign-saved-designs>li').length === 0) {
							$('#customdesign-saved-designs').append('<p class="empty">No item found!</p>');
						}
					}
				});

			},

			my_designs : function(design){
				
				if (design === undefined || design === null)
					return;
				
				// delete old data not combine version 1.7.1+
				if (customdesign.fn.version_compare('1.7.1', design.system_version) > 0) {
					customdesign.indexed.delete(design.id, 'designs');
					customdesign.indexed.delete(design.id, 'dumb');
					return;
				};
				
				design.screenshot = typeof design.screenshot == 'string' ?
									URL.createObjectURL(customdesign.fn.url2blob(design.screenshot)) : 
									customdesign.data.assets+'assets/images/default_category.jpg';
									
				customdesign.ops.my_designs[design.id] = design;
				
				var el = customdesign.get.el('saved-designs'), lis = '';
				
				el.find('p.empty').remove();
				
				lis += '<li data-id="'+design.id+'" data-use-text="'+customdesign.i(212)+'" data-func="edit" data-save-text="'+customdesign.i(213)+'" data-created="'+design.created+'" data-name="'+design.name+'" class="bgcolorafter">\
							<div data-view="stages">\
								<span>\
								  <img src="'+design.screenshot+'" height="150" />\
								</span>\
							</div>\
							<span data-view="name" data-id="'+design.id+'" data-func="name" title="'+customdesign.i(52)+'" data-enter="blur" contenteditable>'+(design.name ? design.name : 'Untitled')+'</span>\
							<em data-view="date">'+customdesign.fn.date('h:m D d M, Y', design.updated*1000)+'</em>\
							<i class="customdesignx-android-close" data-func="delete" title="'+customdesign.i(51)+'"></i>\
						</li>';

				el.append(lis);

			
			},

			shapes : function(data) {

				if (customdesign.get.el('shapes').find('ul.customdesign-list-items').length === 0) {
					customdesign.get.el('shapes').html(
						'<p class="gray">'+customdesign.i(158)+'</p>\
						<div class="customdesign-tab-body">\
							<ul class="customdesign-list-items"></ul>\
						</div>');
				}

				if (data.length > 0) {
					var ul = customdesign.get.el('shapes').find('ul.customdesign-list-items');
					data.map(function(sh) {
						ul.append(
							'<li class="customdesign-clipart" \
							data-ops="[{\
								&quot;type&quot;: &quot;shape&quot;,\
								&quot;resource&quot;: &quot;shape&quot;,\
								&quot;width&quot;: 60,\
								 &quot;height&quot;: 60 ,\
								 &quot;name&quot;: &quot;'+sh.name+'&quot;\
							}]">'+sh.content+'</li>'
						);
					});

					customdesign.cliparts.add_events();

				}else html += '<h3>No item found</h3>';

			},

			fonts : function(fonts){

				var uri = '//fonts.googleapis.com/css?family=',
					txt = '',
					id = '',
					active = '',
					list = '';

				if (fonts) {
					localStorage.setItem('CUSTOMDESIGN_FONTS', JSON.stringify(fonts));
				}else{
					if (!localStorage.getItem('CUSTOMDESIGN_FONTS')) {
						localStorage.setItem('CUSTOMDESIGN_FONTS', typeof customdesign.data.default_fonts == 'string' ? customdesign.data.default_fonts : JSON.stringify(customdesign.data.default_fonts));
					}
					fonts = JSON.parse(localStorage.getItem('CUSTOMDESIGN_FONTS'));
				}
				
				customdesign.get.el('text-ext').html('');
				
				try {
					active = customdesign.stage().canvas.getActiveObject().fontFamily;
				}catch(ex){active = '';};

				window.customdesign_render_text = function(family, font, fontObj) {

					if ($('#customdesign-text-ext li[data-family="'+family+'"]').length > 0)
						return;
					
					var fontShow = family;
					if(typeof fontObj != "undefined" && typeof fontObj.name_desc != "undefined" && fontObj.name_desc != '' && fontObj.name_desc != null){
						fontShow = fontObj.name_desc;
					}
					var el = $('<span data-family="'+family+'" draggable="true" data-act="add" '+
							'data-ops=\'[{"type":"i-text", "fontSize": "30", "fontFamily": "'+family+'", '+
							(font !== undefined ? '"font": "'+font.replace('\\', '/')+'",': '')+
							'"textAlign": "center", "text": "'+fontShow+'"}]\'>\
							<svg width="10" height="40" xmlns="http://www.w3.org/2000/svg" \
								xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none">\
								<g>\
									<text fill="#FFFFFF" stroke="none" stroke-width="0" stroke-linecap="round" \
										stroke-linejoin="round" x="0" y="30" text-anchor="middle" \
											font-size="30px" font-family="'+family+'">\
										<tspan x="50%" dy="0">'+fontShow+'</tspan>\
									</text>\
								</g>\
							</svg>\
						</span>');

					$('#customdesign-text-ext').append(el);

					customdesign.design.event_add_text(el.get(0));

					customdesign.fn.getTextWidth({family: family, size: 30, text: family}, function(m){
						el.find('svg').attr({width: (m.width+18)});
					});

				};

				customdesign_render_text('Arial');

				if (customdesign.data.fonts && customdesign.data.fonts.length > 0) {
					customdesign.data.fonts.map(function(font){

						if (font.name.indexOf('"') > -1)
							return;

						var fontShow = font.name;
						if(typeof font != "undefined" && typeof font.name_desc != "undefined" && font.name_desc != '' && font.name_desc != null){
							fontShow = font.name_desc;
						}

						list += '<font'+(active == font.name ? ' class="selected"' : '')+
								' data-family="'+font.name+'" \
								style="font-family: \''+font.name+'\'" \
								data-source="'+font.upload+'">'+fontShow+
							'</font>';

						customdesign.tools.load_font(
							font.name,
							'url('+customdesign.data.upload_url+font.upload.replace(/\\/g, '/')+')',
							function(family){
								customdesign_render_text(family, font.upload, font);
							}
						);

					});
				}

				Object.keys(fonts).map(function(family){

					txt = decodeURIComponent(family).replace(/ /g, '+')+':'+
						  decodeURIComponent(fonts[family][1]);

					list += '<link onload="customdesign_render_text(\''+decodeURIComponent(family)+'\', \''+ encodeURIComponent(JSON.stringify(fonts[family]))+'\')" rel="stylesheet" href="'+(uri+txt)+'" \
							type="text/css" media="all" />\
							<font'+(active == decodeURIComponent(family) ? ' class="selected"' : '')+
								' data-family="'+decodeURIComponent(family)+'" \
								style="font-family: \''+decodeURIComponent(family)+'\'">'+
									decodeURIComponent(family)+
							'</font>';

				});

				customdesign.get.el('fonts').html(list);

			},
			
			stage_nav : function () {
				
				var stages = customdesign.data.stages,
					stage_nav = [],
					i = 1,
					first_stage = '',
					thumbn_url = '',
					total =  stages['colors'] === undefined ? Object.keys(stages).length : Object.keys(stages).length-1;
	
				if (typeof stages == 'object') {
					
					Object.keys(stages).map(function(s){
						
						if (s != 'colors') {
							
							if (first_stage === '')
								first_stage = s;
								
							if (stages[s].overlay !== false)
								stages[s].overlay = true;
								
							stages[s].color = customdesign.data._color;

							var stageColor = customdesign.get.color();
							
							if (
								(stages[s].url !== undefined && stages[s].url !== '') ||
								stages[s].image !== undefined
							) {
									
								if (!stages[s].image) {
									stages[s].image = (
										stages[s].source == 'raws' ? 
										customdesign.data.assets+'raws/' : 
										customdesign.data.upload_url
									)+stages[s].url;
								};
								
								if(
									sessionStorage.getItem('customdesign_change_product') !== null && 
									stages[s].data !== undefined &&
									stages[s].data.screenshot !== undefined &&
									stages[s].data.screenshot !== ''
								){
									stages[s].data.screenshot = '';
									stageColor = '';
								}
								if (stages[s].screenshot === undefined) {
									if (
										stages[s].data !== undefined &&
										stages[s].data.screenshot !== undefined &&
										stages[s].data.screenshot !== ''
									)
										stages[s].screenshot = stages[s].data.screenshot;
									else if (
										stages[s].template !== undefined && 
										stages[s].template.screenshot !== undefined
									)
										stages[s].screenshot = stages[s].template.screenshot;
									else if (stages[s].image)
										stages[s].screenshot = stages[s].image;
								};
								
								thumbn_url = '';
								
								if (stages[s].screenshot !== undefined && stages[s].screenshot !== '')
									thumbn_url = stages[s].screenshot;
								else if (stages[s].thumbnail !== undefined && stages[s].thumbnail !== '')
									thumbn_url = customdesign.data.upload_url+stages[s].thumbnail;
								else thumbn_url = stages[s].image;
								
								label =(
										stages[s].label !== undefined && 
										stages[s].label !== ''
									) ? stages[s].label : (customdesign.i('_'+s) ? customdesign.i('_'+s) : '');
								
								var additional_price = 0;
								if(typeof(stages[s].addon) != "undefined" && typeof(stages[s].addon.additional_price) != "undefined" && stages[s].addon.additional_price != null){
									additional_price = stages[s].addon.additional_price;
								}
								stage_nav.push(
									'<li data-additional_price="'+additional_price+'" data-stage="'+s+'" data-tip="true"'+(s === customdesign.current_stage ? ' class="active"' : '')+'>\
										<img style="background:'+stageColor+'" data-stage="'+s+'" src="'+thumbn_url+'" />\
										<span data-stage="'+s+'">'+(label !== '' ? label+' ('+i+'/'+total+')' : i+'/'+total)+'</span>\
									</li>'
								);
								
								i++;
								
							};
							
						}
					});
					if(sessionStorage.getItem('customdesign_change_product') !== null){
						sessionStorage.removeItem('customdesign_change_product');
					}
					
					if (stage_nav.length > 1) {
						stage_nav.unshift('<li data-nav="prev" data-tip="true"><i data-svg="prev"></i><span></span></li>');
						stage_nav.push('<li data-nav="next" data-tip="true"><i data-svg="next"></i><span></span></li>');
					};
					
					stage_nav = customdesign.apply_filters('stage_nav', stage_nav);
					
				};
				
				customdesign.get.el('stage-nav').find('>ul').html(stage_nav.join('')).css({
					display: stage_nav.length > 1 ? 'inline-block' : 'none'
				});
				
				$('#customdesign-stage-nav ul').sortable({
					items: '>li[data-stage]',
					start: function(e, ui) {
						if (
							!ui.item.closest('#customdesign-stage-nav').hasClass('stages-expand') ||
							ui.item.closest('#customdesign-stage-nav').hasClass('preview-designs')
						) {
							setTimeout(function(el) {
								try {el.sortable("cancel");}catch(ex){};
							}, 0, $(this));
						}
				    },
				    beforeStop: function() {
					    var _stages = {};
					    $('#customdesign-stage-nav ul li[data-stage]').each(function() {
						    _stages[this.getAttribute('data-stage')] = customdesign.data.stages[this.getAttribute('data-stage')];
					    });
					    customdesign.data.stages = _stages;
					    customdesign.render.stage_nav();
				    }
				});
				
				customdesign.fn.stage_nav();
				
				customdesign.actions.do('render_stage_nav');
				
				return first_stage;
					
			},
			
			product : function(data, callback, designs) {
				
				data = customdesign.apply_filters('product', data);
				data = $.extend(true, {}, data);
				
				if (Object.keys(data.stages).length > 0 && Object.values(data.stages)[0].color)
					customdesign.data.color = Object.values(data.stages)[0].color;
				else delete customdesign.data.color;
				
				if (data.variations !== undefined && data.variations !== '' && typeof data.variations == 'string')
					data.variations = customdesign.fn.dejson(data.variations);
				
				if (data.attributes !== undefined && data.attributes !== '' && typeof data.attributes == 'string')
					data.attributes = customdesign.fn.dejson(data.attributes);
				
				if (data.stages !== undefined && data.stages !== '' && typeof data.stages == 'string')
					data.stages = customdesign.fn.dejson(data.stages);
				
				delete data.stages.options;
				
				customdesign.ops.product_data = data;
				customdesign.data.printings_cfg = data.printings_cfg;
				
				if (Object.keys(data.stages).length === 0) {
					customdesign.f(false);
					$('#customdesign-main').html(
						'<div id="customdesign-no-product" style="display: block;">\
							<p>'+customdesign.i(208)+'</p>\
							<button class="customdesign-btn" id="customdesign-select-product">\
								<i class="customdesignx-android-apps"></i> \
								'+customdesign.i(87)+'\
							</button>\
						</div>');
					
					$('#customdesign-select-product').on('click', customdesign.render.products_list);
					
					return customdesign.fn.notice(customdesign.i(209), 'error', 5000);
				}
				
				var variations = data.variations !== undefined ? data.variations : {};
				
				customdesign.data.variations = variations;
				// Get data from variation if valid one of variations
				var vari_data = customdesign.fn.process_variations(variations.default, null);
				
				customdesign.data.variation = vari_data.variation;
				customdesign.data.cfgstages = vari_data.cfgstages;
					
				if (
					typeof data.templates == 'object' && 
					Object.keys(data.templates).length > 0
				) {
					Object.keys(data.templates).map(function(s) {
						if (data.stages[s] !== undefined) {
							data.stages[s].template = data.templates[s];
						}
					});
				};
				
				customdesign.data.product = data.id;
			
				if (data.saved_stages === undefined) {
					customdesign.data.stages = customdesign.fn.keep_current_designs(vari_data.stages);
				} else {
					var _stages = {};
					Object.keys(data.saved_stages).map(function(s) {
						if (vari_data.stages[s] !== undefined) {
							_stages[s] = vari_data.stages[s];
							_stages[s].data = data.saved_stages[s].data;
						} else _stages[s] = data.saved_stages[s];
					});
					customdesign.data.stages = _stages;
				};
				
				customdesign.data.cfgprinting = vari_data.cfgprinting;
				
				if (vari_data.cfgprinting)
					customdesign.data.printings_cfg = vari_data.printings_cfg;
					
				customdesign.data.printings = vari_data.printings;
				
				customdesign.fn.set_url('product_base', data.id);
				
				if (data.product !== null && data.product !== undefined && data.product !== 0)
					customdesign.fn.set_url('product_cms', data.product);
				
				customdesign.get.el('main').find('.customdesign-stage,#customdesign-no-product').remove();
				customdesign.get.el('navigations').find('ul[data-block] li.active').removeClass('active');
				
				customdesign.active_stage(customdesign.render.stage_nav(), function(){
					
					var stage = customdesign.stage();
					
					if (customdesign.data.share !== undefined) 
					{
						
						customdesign.f('Loading share data..');
						
						$.get(customdesign.data.upload_url+'shares/'+customdesign.data.share+'.lumi', function(res) {
			                try {
								res = JSON.parse(res);
							}catch(ex){
								res = {};
							};
							if (res.stages !== undefined) {
								
								customdesign.tools.imports(res, function(){
									if (customdesign.ops.first_completed !== true) {
										customdesign.actions.do('first-completed');
										customdesign.ops.first_completed = true;
									};
									$('#customdesign-general-status').html(
										'<span>\
											<i class="customdesignx-android-checkmark-circle"></i> '+
											customdesign.i(136)+
										'</span>'
									);
								});
								
								delete res;
									
							};
							
			            }).done(function() {}).fail(function(data, textStatus, xhr) {
			                customdesign.fn.notice('SHARE LINK ERROR: '+data.status, 'error', 5000);
			            }).always(function() {
				            customdesign.f(false);
			            });
						delete customdesign.data.share;
						
					} 
					// hash : 5fecb5125fdb9c9cf8f2e54802cfb020
					else if (customdesign.fn.url_var('cart', '') !== '' && sessionStorage.getItem("CUSTOMDESIGN-START-NEW") !== null && sessionStorage.getItem('kCUSTOMDESIGN-START-NEW') === true) 
					{
						sessionStorage.setItem('CUSTOMDESIGN-START-NEW', false);
						customdesign.f('Processing..');
						
						customdesign.indexed.get(customdesign.fn.url_var('cart'), 'cart', function(res){
							
							if (res === undefined)
								return customdesign.f(false);
							
							if (res['template'] !== undefined){
								customdesign.cart.template = res.template.stages;
								customdesign.cart.price.template = res.template.price;
							}
							
							if (res['extra'] !== undefined){
								customdesign.cart.price.extra = res.extra;
							}
							
							customdesign.tools.imports(res, function(){
								if (customdesign.ops.first_completed !== true) {
									customdesign.actions.do('first-completed');
									customdesign.ops.first_completed = true;
								};
							});
							
						});
						
						for (var s in customdesign.data.stages) {
							if (customdesign.data.stages[s].template !== undefined)
								customdesign.data.stages[s].template.noload = true;
						};
						
						return;
						
					}
					
					stage.screenshot = customdesign.tools.toImage({
						stage: stage,
						is_bg: 'full', 
						multiplier: 1/window.devicePixelRatio
					});
					
					$('#customdesign-stage-nav img[data-stage="'+customdesign.current_stage+'"]').attr({
						src: stage.screenshot
					});
					
					if (typeof callback == 'function')
						callback();
					
				});
				
				/*
				* Process ext attributes (e.g: woocommerce product variations)
				*/
				
				vari_data.ext_attributes = data.ext_attributes;
				vari_data.ext_attributes_value = data.ext_attributes_value;
				vari_data.ext_attributes_callback = data.ext_attributes_callback;
				
				customdesign.render.product_attrs(vari_data);
				customdesign.actions.do('product', vari_data);
				
			},
			
			product_attrs : function(data) {
				
				var p = customdesign.get.el('product');
				
				if (customdesign.ops.doctitle === undefined)
					customdesign.ops.doctitle = document.title;
					
				document.title = data.name+' | '+customdesign.ops.doctitle;
				
				p.find('nav.customdesign-add-cart-action').show();
				p.find('header').show().find('>name').html('<t>'+(data.name ? data.name : '')+' &nbsp; </t>');
				p.find('header>price').html(customdesign.fn.price(data.price));
				p.find('header>sku').html(data.sku ? 'SKU: '+data.sku : '');
				
				if (data.description !== undefined && data.description !== '') {
					
					var maxl = 100, 
						more = false, 
						des = data.description.substr(0, maxl);
					
					p.find('desc').data({desc: data.description});
					
					if (data.description.length > maxl)
						more = true;
					
					p.find('span').show().html(des);
					p.find('desc').show().find('a[href="#more"]')
					 .css({display: (more ? 'inline-block' : 'none')})
					 .off('click')
					 .on('click', function(e) {
						$(this).toggleClass('open');
						if ($(this).hasClass('open')) {
							$(this).html(customdesign.i(137));
							$(this).closest('desc').find('span').html($(this).closest('desc').data('desc'));	
						} else{
							$(this).html(customdesign.i(69));
							$(this).closest('desc').find('span').html($(this).closest('desc').data('desc').substr(0, maxl));
						}
						e.preventDefault();
					});
				} else p.find('desc').hide();
				
				customdesign.get.el('cart-options').show();
				
				customdesign.render.cart_change();
				customdesign.cart.render(data);
					
			},
			
			cart_change : function() {

				var current_id = customdesign.fn.url_var('cart', ''),
					btn = customdesign.get.el('cart-action'),
					items = localStorage.getItem('CUSTOMDESIGN-CART-DATA'),
					wrp = customdesign.get.el('cart-items'),
					ul = wrp.find('ul[data-view="items"]'),
					total = 0, item, keys, color;
				
				if (btn.length > 0) {
					if (current_id === '')
						btn.attr({'data-action': 'add-cart'}).find('>span').html(btn.data('add'));
					else
						btn.attr({'data-action': 'update-cart'}).find('>span').html(btn.data('update'));
				}
				
				ul.html('');
				
				try {
					items = JSON.parse(items);
					keys = Object.keys(items);
				}catch(ex) {
					items = {};
					keys = [];
				}
				
				var item, color, qty;
				
				if (Object.keys(items).length > 0) {
					Object.keys(items).map(function(id) {
						item = items[id];
						if (customdesign.fn.version_compare('1.7.1', item.system_version) <= 0) {
							color = '#fefdfe';
							qty = item.options.quantity ? item.options.quantity : 1;
							if (
								typeof item.attributes == 'object' &&
								typeof item.options == 'object' &&
								Object.keys(item.attributes).length > 0
							) {
								Object.keys(item.attributes).map(function(im) {
									if (
										item.attributes[im].type == 'product_color' &&
										item.options[im] !== undefined
									) color = item.options[im];
								});
							};
							if (
								typeof item.attributes == 'object' &&
								typeof item.options == 'object' &&
								Object.keys(item.attributes).length > 0
							) {
								Object.keys(item.attributes).map(function(im) {
									if (
										item.attributes[im].type == 'quantity' &&
										item.options[im] !== undefined
									) qty = item.options[im];
								});
							};
							
							try {
								if (isNaN(qty)) {
									var qt = 0;
									Object.values(JSON.parse(qty)).map(function(q) {
										qt += parseInt(q);
									});
									qty = qt;
								}
							} catch (ex) {};
							
							ul.append(
							'<li data-func="edit" data-id="'+id+'">\
								<span data-view="thumbn">\
									<img data-func="edit" title="'+customdesign.i('edit')+'" data-id="'+id+'" style="background: '+color+'" src="'+item.screenshot+'" />\
								</span>\
								<span data-view="info">\
									'+(id != current_id ? 
										'<name>\
											<a href="#edit" data-func="edit" title="'+customdesign.i('edit')+'" data-id="'+id+'">'+
												item.name+'\
											</a>\
										</name>' + '<quantity>x '+qty+'</quantity>' :
										'<name>'+item.name+'</name> ' +'<quantity>x '+qty+'</quantity>'
									)+'<price>'+customdesign.fn.price(item.price_total)+'</price> \
									<a href="#remove" title="'+customdesign.i('remove')+'">\
										<i class="customdesignx-android-close" data-func="remove" data-id="'+id+'"></i>\
									</a>\
									'+(id == current_id ? '<small>'+customdesign.i(72)+'</small> ' : '')+'\
								</span>\
							</li>');
							total += parseFloat(item.price_total);
						}
					});
					ul.append('<li><strong>'+customdesign.i(74)+': '+customdesign.fn.price(total.toFixed(2))+'</strong></li>');
					ul.attr({'data-empty': 'false'});
				}else {
					ul.attr({'data-empty': 'true'}).html('<p><i class="customdesignx-bag"></i> '+customdesign.i(71)+'</p>');
				}

				customdesign.get.el('addToCart').find('small').remove();
				customdesign.get.el('addToCart').append(' <small>'+keys.length+'</small>');
				
				customdesign.actions.do('cart-change');
				
			},

			cart_details : function(e) {

				var items = JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA') || '{}'),
					ind = 1, item, attr, total = 0, current = customdesign.fn.url_var('cart'),
					table = ['<table class="customdesign-table sty2"><thead>',
								'<tr>',
								'<th> &nbsp; # &nbsp; </th>',
								'<th>'+customdesign.i(76)+'</th>',
								'<th data-align="left"><div style="width: 240px;">'+customdesign.i(77)+'</div></th>',
								'<th data-align="center">'+customdesign.i(104)+'</th>',
								'<th data-align="center">'+customdesign.i(79)+'</th>',
								'<th data-align="center"><div style="width: 120px;">'+customdesign.i(78)+'</div></th>',
								'</tr>',
							'</thead>',
							'<tbody>'],
					ext_qty = function (val){
						if(val.indexOf('-') > -1){
							val = val.split('-');
							var qty = val[val.length-1];
							val = val.slice(0, -1);
							return val.join('-') + ' ('+qty+')';
						}
						
						return val;
						
					};
					
				if (Object.keys(items).length > 0) {
					Object.keys(items).map(function(id) {
						
						if (customdesign.fn.version_compare('1.7.1', items[id].system_version) > 0) {
							delete items[id];
							localStorage.setItem('CUSTOMDESIGN-CART-DATA', JSON.stringify(items));
							customdesign.indexed.delete(id, 'cart');
							return;
						};
							
						var item = items[id], val, attr = '';
						
						Object.keys(item.options).map(function(at) {
							
							val = item.options[at];
							
							if (val === '')
								return;
								
							if (
								item.attributes[at].type == 'product_color' ||
								item.attributes[at].type == 'color'
							) {
								
								var lb = customdesign.fn.attr_label(val, item.attributes[at].values);
								
								val = '<span title="'+lb+'" style="background: '+val+';padding: 3px 5px;border-radius: 2px;color:'+customdesign.fn.invert(val)+'">'+lb+'</span>';
								
							} else if (item.attributes[at].type == 'quantity') {
								if (val !== '' && isNaN(parseInt(val))) {
									try {
										val = JSON.parse(val);
										Object.keys(val).map(function(o) {
											var lb = customdesign.fn.attr_label(o, item.attributes[at].values.multiple_options);
											if(val[o] == 0){
												delete val[o];
												return;
											}
											val[o] = lb+': '+val[o];
										});
										val = Object.values(val).join(', ');
									} catch (ex) {};
								}
							} else if (typeof item.attributes[at].values == 'object') {
								val = customdesign.fn.attr_label(val, item.attributes[at].values);
							};
							
							attr += '<strong>'+item.attributes[at].name+':</strong> '+val+'<br />';
							
						});
						
						table = table.concat([
							'<tr>',
							'<td>'+(ind++)+'</td>',
							'<td class="product-thumb">',
							'<div data-design-layer="'+id+'"></div>',
							'<span class="product-title"  align="center">'+item.name+'</span>',
							'</td>',
							'<td>'+attr+'<strong>'+customdesign.i(191)+':</strong> '+item.stages+'</td>',
							'<td data-align="center">'+customdesign.fn.price(item.price_total)+'</td>',
							'<td data-align="center">'+customdesign.fn.date('h:m D d M, Y', item.updated)+'</td>',
							'<td data-align="center">',
							(current != id ? '<a href="#edit" data-id="'+id+'">'+customdesign.i('edit')+'</a>' : customdesign.i(72)),
							'&nbsp; | &nbsp;<a href="#remove" data-id="'+id+'">'+customdesign.i('remove')+'</a>',
							'</td>'
						]);
						
						setTimeout(customdesign.fn.cart_thumbn, 100, id);
						
						total += parseFloat(item.price_total);
						
					});
				
					table = table.concat(['</tbody>',
						'<tfoot>',
						'<tr>',
						'<td colspan="3" class="customdesign-total">'+customdesign.i(74)+': '+customdesign.fn.price(total.toFixed(2)),
						'</td>',
						'<td colspan="3" data-align="right">',
						'<button class="customdesign-btn-primary">'+customdesign.i(75)+' <i class="customdesignx-android-arrow-forward"></i></button>',
						'</td>',
						'</tr>',
						'</tfoot>',
						'</table>']);
				
				}else{
					table = table.concat(['<tr>', '<td colspan="6"><h3>'+customdesign.i(42)+'</h3></td>','</tr>','</table>']);
				};
				
				customdesign.tools.lightbox({
					content: '<div id="customdesign-cart-details" class="customdesign_content customdesign_wrapper_table">\
								<h3 class="title">'+customdesign.i(73)+'</h3>\
								<div>'+table.join('')+'</div>\
							</div>'
				});
				
				customdesign.trigger({
					
					el: $('#customdesign-cart-details'),
					
					events: {
						'a[href="#edit"]': 'edit_item',
						'a[href="#remove"]': 'remove_item',
						'tfoot button.customdesign-btn-primary': customdesign.cart.do_checkout
					},
					
					edit_item: function(e) {
						customdesign.cart.edit_item(this.getAttribute('data-id'), e);
						e.preventDefault();
					},
					
					remove_item: function(e) {
						
						if (confirm(customdesign.i('sure'))) {
							
							var id = this.getAttribute('data-id'),
								total_elm = $('#customdesign-cart-details').find('tfoot tr:first td'),
								total = 0;
							
							if (customdesign.fn.url_var('cart', null) == id)
								customdesign.fn.set_url('cart', null);
							
							var items = JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA'));
							delete items[id];
							
							localStorage.setItem('CUSTOMDESIGN-CART-DATA', JSON.stringify(items));
							customdesign.render.cart_change();
							
							$(this).closest('tr').remove();
							
							//calc total 
							Object.keys(items).map(function(i) {
								if (items[i].price_total !== undefined)
									total += parseFloat(items[i].price_total);
							});
							
							$(total_elm[0]).html(
								customdesign.i(74)+': '+customdesign.fn.price(total.toFixed(2))
							);
							
							if(total == 0) {
								$(total_elm[1]).html('');
								$('#customdesign-cart-details').find('tfoot .customdesign-btn-primary').hide();
							}
							
						};
						e.preventDefault();
						
					}
					
				});
				
				e.preventDefault();
				
			},
			
			categories : function (type, res) {
				
				var btn = $('button[data-func="show-categories"][data-type="'+type+'"]');
				
				if (res !== undefined) {
					customdesign.ops.categories[type] = res;
					if (res.category !== 0 && res.category !== '' && res.category_name !== '')
						btn.find('span').html(res.category_name);
					else btn.find('span').html(customdesign.i(57));
				}else res = customdesign.ops.categories[type];
				
				var items = res.categories,
					curr = res.category,
					wrp = customdesign.get.el('x-thumbn-preview'),
					html = '<div class="customdesign-categories-wrp" data-type="'+type+'">';
				
				if (items === undefined || items.length === 0)
					wrp.find('>div').html('<div class="customdesign-categories-wrp" data-type="'+type+'"><br><br>'+customdesign.i(42)+'</div>');
				else {
					
					if (res.category_parents.length > 0) {
						
						if (res.category_parents.length === 1 && res.category_parents[0].id === '') {
							html += '<nav><span>'+res.category_parents[0].name+'</span></nav>';
						}else{
						
							html += '<nav><a href="#category-all" data-act="item" data-id="">'+customdesign.i(57)+'</a>';
							
							res.category_parents.map(function(cp){
								if (cp.id != res.category)
									html += '<i class="customdesignx-ios-arrow-forward"></i><a href="#category-'+cp.id+'" data-act="item" data-id="'+cp.id+'">'+cp.name+'</a>';
								else html += '<i class="customdesignx-ios-arrow-forward"></i><span>'+cp.name+'</span>';
							});
							html += '</nav>';
							
						}
					}
					
					html += '<ul class="smooth">';
					items.map(function(item) {
						var thumbn = item.thumbnail;
						if (thumbn === null || thumbn === undefined || thumbn === '')
							thumbn = customdesign.data.assets+'assets/images/default_category.jpg';
						else if(thumbn.indexOf('http') !== 0) 
							thumbn = customdesign.data.upload_url+'thumbnails/'+thumbn;
						html += '<li data-act="item" data-id="'+item.id+'"'+(curr == item.id ? ' class="active"' : '')+'>\
									<span style="background-image:url(\''+thumbn+'\');"></span>\
									<p>'+item.name+'</p>\
								 </li>';
					});
					html += '</ul></div>';
					
					var scrt = wrp.find('.customdesign-categories-wrp ul').scrollTop();
					wrp.find('>div').html(html);
					wrp.find('.customdesign-categories-wrp ul').scrollTop(scrt);
					
					customdesign.trigger({
						
						el: wrp,
						
						events: {
							'div.customdesign-categories-wrp': 'click'
						},
						click: function(e) {
							
							var el = e.target.getAttribute('data-act') ? $(e.target) : $(e.target).closest('[data-act]'),
								type = this.getAttribute('data-type'),
								act = el.data('act');
								
							if (!act)return;
							
							switch (act) {
								case 'item':
								
									$('.customdesign-categories-wrp').attr({'data-process': 'true'});
									
									customdesign.ops[type+'_category'] = el.data('id');

									customdesign.ops[type+'_index'] = 0;
									customdesign.ops[type+'_loading'] = false;
			
									customdesign.get.el(type+'-list').find('ul').html('');
									customdesign.get.el(type+'-list').trigger('scroll');
									
								break;
							}
							
							e.preventDefault();
							
						}
					});
					
				}
			1},
			
			products_list : function (btn_txt) {
				
				if (!btn_txt)
					btn_txt = customdesign.i(87);
				
				customdesign.tools.lightbox({
					content: '<div id="customdesign-change-products-wrp" data-btn="'+btn_txt+'" >\
								<center><i class="customdesign-spinner x3"></i></center>\
							  </div>'
				});

				if (customdesign.ops.products !== undefined)
					return customdesign.response.list_products(customdesign.ops.products);

				customdesign.post({
					action: 'list_products',
					s: '',
					category: '',
					product_cms: null,
					index: 0
				});
				
			},
			
			cart_confirm : function() {
				
				var el = $('<div id="customdesign-update-cart-confirm" data-func="close" style="opacity:0">\
							<div>\
								<img src="'+customdesign.data.assets+'assets/images/done.svg" alt="" />\
								<em>'+customdesign.i(172)+'!</em>\
								<ul>\
									<li>\
										<a href="#details" data-func="details">'+customdesign.i(173)+'</a>\
									</li>\
									<li>\
										<a href="#new" data-func="new">'+customdesign.i(174)+'</a>\
									</li>\
								</ul>\
								<br>\
								<button class="customdesign-btn-primary" data-func="checkout">\
									'+customdesign.i(175)+'\
									<i class="customdesignx-android-arrow-forward" data-func="checkout"></i>\
								</button>\
								<i class="customdesignx-android-close close" title="'+customdesign.i(176)+'" data-func="close"></i>\
							</div>\
						</div>');
						
				$('#CustomdesignDesign').append(el);
				
				el.animate({opacity: 1}, 150).on('click', function(e) {
					
					e.preventDefault();
					
					var _this = $(this), 
						func = e.target.getAttribute('data-func');
					
					customdesign.get.el('proceed').removeClass('active');
						
					switch (func) {
						case 'close':
							$(this).fadeOut(150, function() {$(this).remove();});
						break;
						case 'details' : 
							customdesign.render.cart_details(e); 
						break;
						case 'new' : 
							customdesign.fn.set_url('cart', null);
							customdesign.get.el('general-status').html('');
							customdesign.render.products_list();
						break;
						case 'checkout' : 
							customdesign.cart.do_checkout(e); 
						break;
					}
					
					if (func)
						$(this).fadeOut(150, function() {$(this).remove();});
					
				});
				
			}

		},

		indexed : {

			req: null,
			db: null,
			stores: {
				'uploads': null, 
				'designs': null, 
				'dumb': null, 
				'cart': null,
				'categories': null
			},

			init: function() {

				var t = this;

				t.req = indexedDB.open("customdesign", 8);
				t.req.onsuccess = function (e) {

			        if ( e.target.result.setVersion) {
			            if ( e.target.result.version != t.ver) {
			                var setVersion =  e.target.result.setVersion(t.ver);
			                setVersion.onsuccess = function () {
				                t.store(e.target.result);
			                    t.ready(e.target.result);
			                };
			            }
			            else t.ready(e.target.result);
			        }
			        else t.ready(e.target.result);
			    };

			    t.req.onupgradeneeded = function (e) {
				    t.store(e.target.result);
			    };

			},

			ready : function(db) {
				
				this.db = db;
				
				if (customdesign.data.version !== undefined && typeof this.onDBReady == 'function') {
					this.onDBReady();
				}
				
			},

			save : function(ob, storeName, callback) {
				
				if (this.db == null)
					return callback(null);

				var trans = this.db.transaction(ob.length === 2 ? [storeName, 'dumb'] : [storeName], "readwrite");
		        var store = trans.objectStore(storeName);
				
				if (ob.id === null || ob.id === undefined)
					ob.id = parseInt(new Date().getTime()/1000).toString(36)+':'+Math.random().toString(36).substr(2);
				
		        var	obj = $.extend(true, {
			        	created: new Date().getTime()
			        }, (ob[0] !== undefined ? ob[0] : ob));
				
				obj = customdesign.indexed.prepare(obj);
				
				var process = store.put(obj, obj.id);

				if (typeof callback == 'function')
					process.onsuccess = callback;

				if (ob[1] !== undefined) {

					var	obj_dumb = $.extend(true, {
			        	id: obj.id,
			        	created: obj.created
			        }, ob[1]);
					
					obj_dumb = customdesign.indexed.prepare(obj_dumb);
					
			        trans.objectStore('dumb').put(obj_dumb, obj.id);

				}


			},

			get : function(id, storeName, callback){

				if (this.db == null)
					return callback(null);

				var trans = this.db.transaction([storeName], "readwrite");
			    var store = trans.objectStore(storeName);
				try{
					var process = store.get(id);
				}catch(ex){}
				trans.oncomplete = function(event){
					callback(process !== undefined ? process.result : null);
					delete process;
					delete trans;
					delete store;
					delete go;
				};
				trans.onerror = function(){
					callback(null);
				};

			},

			list : function(callback, storeName, onComplete){

				var t = this;
				if (t.db == null)
					return onComplete(null);

		        var trans = t.db.transaction([storeName], "readwrite");
			    var store = trans.objectStore(storeName);
			    var i = 0;

			    trans.oncomplete = onComplete;

			    var range = customdesign.ops[storeName+'_cursor'] ?
			    			IDBKeyRange.upperBound(customdesign.ops[storeName+'_cursor'], true) : null,
			    	cursorRequest = store.openCursor(range ,'prev');

			    cursorRequest.onerror = function(error) {
			        console.log(error);
			    };
			    
			    cursorRequest.onsuccess = function(evt) {

				    if (i++ > 11) {
					    if (typeof onComplete == 'function')
				    		return onComplete();
						else return;
					};
					
			        var cursor = evt.target.result;
			        if (cursor) {
				        callback(cursor.value);
				        if (onComplete != cursor.id)
			            	cursor.continue();
			        }else{
				    	delete cursor;
				    	delete cursorRequest;
				    	delete range;
				    	delete trans;
				    	delete go;
				        return (typeof onComplete == 'function' ? onComplete('done') : null);
				    }
			    };

			},

			store : function(db) {
				Object.keys(this.stores).map(function(s){
					try {
	                	db.createObjectStore(s);
					}catch(ex){};
                });
			},

			delete : function(id, store) {

				var tranc = this.db.transaction([store, 'dumb'], "readwrite");
				tranc.objectStore(store).delete(id);
				tranc.objectStore('dumb').delete(id);

			},
			
			prepare : function(obj) {
				
				for (var n in obj) {
					if (
						obj[n] !== undefined &&
						obj[n] !== null &&
						typeof obj[n] ==="object"
					) { 
						if (
							obj[n].nodeType === 1 &&
							typeof obj[n].style === "object" &&
							typeof obj[n].ownerDocument === "object"
						) {
							delete obj[n];
						} else {
							obj[n] = customdesign.indexed.prepare(obj[n]);
						}
					}
				}
				
				return obj;
				
			},
			
			onDBReady : function() {
				
				/*
				* Addons callback
				*/
				
				if (customdesign.data.access_core !== undefined && customdesign.data.access_core !== '') {
					customdesign.data.access_core.split(',').map(function(a) {
						if (
							window[a] !== undefined && 
							typeof window[a] == 'function'
						) {
							try {
								window[a](customdesign);
							} catch (ex) {
								console.warn('Error on customdesign addon callback "'+a+'": '+ex.message);
								console.log(ex);
							}
						}
					});
					delete customdesign.data.access_core;
				};
				
				try {
					customdesign.actions.do('db-ready');
				} catch (ex) {
					console.warn(ex.message);
					console.log(ex);
				}
				
				delete customdesign.indexed.onDBReady;
					
			}
		},

		post : function(ops, callback){

			if (!ops.action)
				return customdesign.fn.notice('customdesign.post() missing param action', 'error');

			$.ajax({
				url: customdesign.data.ajax,
				method: 'POST',
				data: customdesign.apply_filters('ajax', $.extend({
					nonce: 'CUSTOMDESIGN-SECURITY:'+customdesign.data.nonce,
					ajax: 'frontend',
					product_base: customdesign.fn.url_var('product_base'),
					product_cms: customdesign.fn.url_var('product_cms')
				}, ops)),
				statusCode: customdesign.response.statusCode,
				success: function(res) {
					if (typeof callback == 'function')
						return callback(res);
					else if (typeof customdesign.response[ops.action] == 'function')
						customdesign.response[ops.action](res);
				}
			});

		},

		response : {

			templates : function(res) {

				var html = '';

				if (res.items && res.items.length > 0) {
					res.items.map(function(item) {
						customdesign.templates.storage[item.id] = customdesign.data.upload_url+item.upload;
						html += '<li style="background-image: url(\''+item.screenshot+'\')" \
								data-ops=\'[{\
									"type": "template", \
									"name": "'+item.name+'", \
									"id": "'+item.id+'", \
									"tags": "'+(item.tags?item.tags:'')+'", \
									"cates": "'+(item.cates?item.cates:'')+'", \
									"screenshot": "'+item.screenshot+'", \
									"price": "'+item.price+'"\
								}]\' class="customdesign-template">\
								<i data-tag="'+item.id+'">'+(item.price?customdesign.fn.price(item.price) : customdesign.i(100))+'</i><i data-info="'+item.id+'"></i>\
								</li>';
					});
					var total = res.total ? res.total : 0;
					customdesign.ops.templates_q = res.q;
					customdesign.ops.templates_category = res.category;
					customdesign.ops.templates_index = parseInt(res.index)+res.items.length;
					if (customdesign.ops.templates_index<total)
						customdesign.ops.templates_loading = false;

				}else html += '<span class="noitems">'+customdesign.i(42)+'</span>';

				customdesign.get.el('templates-list').find('i.customdesign-spinner').remove();
				customdesign.get.el('templates-list').find('ul.customdesign-list-items').append(html);
				
				customdesign.render.categories('templates', res);
				customdesign.templates.add_events();

			},
			
			cliparts : function(res) {

				var html = '';
				
				if (res.items && res.items.length > 0) {
					
					res.items.map(function(item) {
						
						var oid = 'Art-'+item.id;
						
						customdesign.xitems.ops[oid] = [{
							type : 'image',
							name : item.name,
							id : item.id.toString(),
							tags : (item.tags?item.tags:''),
							cates : (item.cates?item.cates:''),
							resource : 'cliparts',
							resource_id : item.id,
							price : parseFloat(item.price),
							url: customdesign.data.upload_url+item.upload
						}];
						
						html += '<li style="background-image: url(\''+item.thumbnail_url+
										'\')" data-ops="'+oid+'" class="customdesign-clipart">'+
									'<i data-tag="'+item.id+'">'+
									(item.price>0?customdesign.fn.price(item.price) : customdesign.i(100))+
									'</i><i data-info="'+item.id+'"></i>'+
								'</li>';
					});
					
					var total = res.total ? res.total : 0;
					
					customdesign.ops.cliparts_q = res.q;
					customdesign.ops.cliparts_category = res.category;
					customdesign.ops.cliparts_index = parseInt(res.index)+res.items.length;
					if (customdesign.ops.cliparts_index<total)
						customdesign.ops.cliparts_loading = false;

				}else html += '<span class="noitems">'+customdesign.i(42)+'</span>';

				customdesign.get.el('cliparts-list').find('i.customdesign-spinner').remove();
				customdesign.get.el('cliparts-list').find('ul.customdesign-list-items').append(html);
				
				customdesign.render.categories('cliparts', res);
				customdesign.cliparts.add_events();

			},

			save_design : function(res) {

				customdesign.f(false);

				if (res.success) {

					customdesign.fn.notice(customdesign.i(21), 'success');

					customdesign.data.design = res.id;
					customdesign.get.el('navigations').find('li[data-tool="designs"]').attr({'data-load': 'designs'});
					/*
					if ( window.location.href.indexOf('design='+res.id+'&') === -1)
						window.history.replaceState({},"", customdesign.data.url+'?design='+res.id+'&product_base='+res.pid);
					*/
				}else if(res.error) {
					customdesign.fn.notice(res.error, 'error');
				}

			},

			my_designs : function(res) {

				if(res.error)
					return customdesign.fn.notice(res.error, 'error');
					
				customdesign.render.my_designs(res);

			},

			edit_design : function(res) {

				if(res.error)
					return customdesign.fn.notice(res.error, 'error');

				try{
					var data = JSON.parse(res.data);
				}catch(ex) {
					return customdesign.fn.notice(ex.message, 'error');
				};
				
				customdesign.tools.imports(data);
				
				customdesign.get.el('share-link').val(customdesign.data.url+'?design='+res.id+'&product_base='+res.pid+'&private_key='+res.share_token)
					   .closest('li[data-view="link"]').removeAttr('data-msg');

				customdesign.get.el('navigations')
					   .find('li[data-tool="share"] p[data-view="radio"] input[name="customdesign-share-permission"]')
					   .get(res.share_permission).checked = true;

				customdesign.data.design = res.id;
				customdesign.data.private_key = res.share_token;
				customdesign.get.el('navigations').find('li[data-tool="designs"]').attr({'data-load': 'designs'});

				if ( window.location.href.indexOf('design='+res.id+'&') === -1) {
					window.history.replaceState({},"", customdesign.data.url+'?design='+res.id+'&product_base='+res.pid);
				}

			},

			delete_design : function(res) {

				if(res.error) {
					return customdesign.fn.notice(res.error, 'error');
				}

				$('ul#customdesign-saved-designs li[data-id="'+res.id+'"]').remove();
				customdesign.fn.notice(customdesign.i(22), 'success');

			},

			design_permission : function(res) {

				if(res.error)
					customdesign.get.el('navigations')
					   .find('li[data-tool="share"] li[data-view="link"]').attr({'data-msg': res.error});

				customdesign.get.el('navigations')
					   .find('li[data-tool="share"] button[data-func="copy-link"]')
					   .removeClass('disabled').next('i').remove();

			},

			shapes : function(res) {

				if(res.error) {
					return customdesign.fn.notice(res.error, 'error');
				}

				$('#customdesign-shapes i.customdesign-spinner').remove();

				if (res.items && res.items.length > 0) {
					
					customdesign.ops.shapes_index = parseInt(res.index)+res.items.length;
					customdesign.ops.shapes_loading = false;
					customdesign.render.shapes(res.items);
					var shapewrp = $('#customdesign-shapes .customdesign-tab-body').get(0);
					
					if (shapewrp.scrollHeight == shapewrp.clientHeight) {
						$(shapewrp).trigger('scroll');
					}
					
				}else $('#customdesign-shapes ul').append('<span class="noitems">'+customdesign.i(42)+'</span>');

			},

			change_lang : function() {
				location.reload();
			},

			list_products : function(res) {
				
				var wrp = $('#customdesign-change-products-wrp'),
					btn_text = wrp.data('btn');
				
				customdesign.ops.products = res;
					
				var cates = ['<ul data-view="categories">',
								'<h3>'+customdesign.i(56)+'</h3>',
								'<li data-id="" '+(res.category === '' ? 'class="active"' : '')+' data-lv="0"> '+customdesign.i(57)+'</li>'],
					prods = ['<h3 data-view="top"><input type="search" value="'+res.s+'" placeholder="'+customdesign.i(63)+'" /></h3>','<ul data-view="products" class="smooth">'];

				if (res.categories) {
					res.categories.map(function(c) {
						cates.push('<li '+(res.category == c.id ? 'class="active"' : '')+' data-id="'+c.id+'" data-lv="'+c.lv+'">'+'&mdash;'.repeat(c.lv)+' '+c.name+'</li>');
					});
				}

				if (res.products && res.products.length > 0) {

					res.products.map(function(p) {
						
						if (p === null)
							return;
							
						if (p.stages !== '' && typeof p.stages == 'string')
							p.stages = customdesign.fn.dejson(p.stages);
						
						var stages = customdesign.fn.pimage(p.stages.stages !== undefined ? p.stages.stages : p.stages);
						
						var cates = '',
							color = (
								p.stages.options !== undefined ? p.stages.options.color :
								(p.stages.colors !== undefined ? p.stages.colors.active : 
									(typeof p.color == 'string' ? p.color.split(':')[0] : '')
								)
							);
						
						if (stages.colors !== undefined)
							delete stages.colors;
							
						var first = Object.keys(stages)[0],
							template = '';
						
						/*if (typeof p.templates == 'object' && p.templates[first] !== undefined)
							template = 'data-template="'+encodeURIComponent
								(JSON.stringify([
									stages[first].edit_zone, 
									p.templates[first], 
									stages[first].product_width, 
									stages[first].product_height
								])
							)+'"';*/
						
						prods.push(
							'<li data-id="'+p.id+'"'+(
									(customdesign.data.product == p.id) ? ' data-current="true"':''
								)+' data-name="'+
									p.name.toLowerCase().trim().replace(/[^a-z0-9 ]/gmi, "")+
								'"'+((p.id !== p.product)? ' data-cms="'+p.product+'"': '')+'>\
								<span data-view="thumbn" data-start="'+btn_text+'">\
									<img '+template+' style="background:'+color+'" src="'+(stages[first] ? stages[first].image : customdesign.data.assets+'assets/images/default_category.jpg')+'" />\
								</span>\
								<span data-view="name">'+p.name+'</span>\
								<span data-view="price">'+customdesign.fn.price(p.price)+'</span>\
							</li>'
						)
					});

				}else prods.push('<li data-view="noitem">'+customdesign.i(42)+'</li>');
				
				if (res.limit < res.total) {
					var pagination = ['<li data-view="pagination">', '<ul>'],
						pages = Math.ceil(res.total/res.limit),
						page = Math.ceil(res.index/res.limit);
					for(var i=1; i<=pages; i++) {
						pagination.push('<li data-page="'+i+'" '+(page == i ? ' class="customdesign-color"' : '')+'>'+i+'</li>');
					}
					pagination.push('</ul></li>');
					prods.push(pagination.join(''));
				}
				
				prods.push('</ul>');
				
				wrp.html(cates.join('')).append(prods.join(''));
				
				/*
				wrp.find('img[data-template]').on('load', function(e) {
					
					var ops = JSON.parse(decodeURIComponent(this.getAttribute('data-template')));
					
					this.removeAttribute('data-template');
					
					var edz = ops[0],
						tem = ops[1],
						rat = this.offsetWidth/ops[2],
						t = rat*(edz.top+(ops[3]/2)-(edz.height/2)),
						l = rat*(edz.left+(ops[2]/2)-(edz.width/2)),
						w = rat*edz.width,
						h = rat*edz.height;
					
					
					$(this).after(
						'<span style="top: '+t+'px; left: '+l+'px; width: '+w+'px; height: '+h+'px;border-radius: '+(rat*edz.radius)+'px" data-view="template">\
							<img style="top: '+(rat*tem.offset.top)+'px; left: '+(rat*tem.offset.left)+'px; height: '+(rat*tem.offset.height)+'px; width: '+(rat*tem.offset.width)+'px; position: absolute;" src="'+tem.screenshot+'" />\
						</span>'
					);
					 
				});
				*/
				
				customdesign.trigger({
					el: $('#customdesign-change-products-wrp'),
					events: {
						'ul[data-view="categories"] li': 'category',
						'ul[data-view="products"] li[data-id]': 'product',
						'h3[data-view="top"] input:keydown': 'search',
						'li[data-view="pagination"] li[data-page]': 'page'
					},
					
					category: function() {

						var wrp = $(this).closest('#customdesign-change-products-wrp'),
							id = this.getAttribute('data-id');
						
						customdesign.ops.products.category = id;
						
						$('#customdesign-change-products-wrp').html('<center><i class="customdesign-spinner x3"></i></center>');
						
						customdesign.post({
							action: 'list_products',
							s: customdesign.ops.products.s,
							category: id,
							product_cms: null,
							index: 0
						});
						
					},

					product: function() {
						
						if (this.getAttribute('data-current') == 'true')
							return;
						
						var id = this.getAttribute('data-id'),
							product = customdesign.ops.products.products.filter(function(p){return p.id == id;});

						if (product.length > 0) {
							if (typeof wrp.data('callback') == 'function') {
								wrp.data('callback')(product[0]);
							} else {
								
								if (customdesign.fn.url_var('cart', '') !== '') {
									customdesign.fn.confirm({
										title: customdesign.i(119),
										primary: {
											text: customdesign.i(124),
											callback: function(e) {
												$('customdesign-general-status').html('');
												customdesign.fn.clear_url([]);
												customdesign.render.product(product[0]);
											}
										},
										second: {
											text: customdesign.i(125),
											callback: function(e) {
												customdesign.fn.clear_url(['cart']);
												customdesign.render.product(product[0]);
											}
										}
									});
								}else{
									sessionStorage.setItem('customdesign_change_product','changed');
									customdesign.fn.clear_url([]);
									customdesign.render.product(product[0]);
								}
								
								customdesign.actions.do('select-product', product[0]);
								
							}
						}
						
						$(this).closest('#customdesign-lightbox').remove();

					},

					search: function(e) {
						
						if (e.keyCode !== 13)
							return;
							
						e.data.el.find('ul[data-view="categories"] li.active').removeClass('active');
						e.data.el.find('ul[data-view="categories"] li[data-id="all"]').addClass('active');
						
						var s = this.value.toLowerCase();
						
						$('#customdesign-change-products-wrp').html('<center><i class="customdesign-spinner x3"></i></center>');
						
						customdesign.post({
							action: 'list_products',
							s: s,
							category: (customdesign.ops.products.category ? customdesign.ops.products.category : ''),
							index: 0,
							product_cms: null
						});
						
						e.preventDefault();
						
					},
					
					page: function(e) {
						
						var p = parseInt(this.getAttribute('data-page'));
						
						$('#customdesign-change-products-wrp').html('<center><i class="customdesign-spinner x3"></i></center>');
						
						var limit = parseInt(customdesign.ops.products.limit);
						
						if (isNaN(limit))
							limit = 10;
						
						customdesign.post({
							action: 'list_products',
							s: customdesign.ops.products.s,
							product_cms: null,
							category: customdesign.ops.products.category,
							index: (p*limit)-limit
						});
					}

				});

			},
			
			categories : function(res) {
				if (res.length > 0) {
					var type = res[0].type;
					customdesign.ops.categories[type] = res;
					customdesign.render.categories(type);
				}
			},
			
			statusCode: {

				403: function() {

					$.post(
						customdesign.data.ajax,
						customdesign.apply_filters('ajax', {
							action: 'extend',
							name: 'general',
							nonce: customdesign.data.nonce,
						}), function(res){

							customdesign.f(false);

							if (res == '-1')
								return customdesign.fn.notice(customdesign.i(23), 'error', 3000);

							customdesign.data.nonce = res;
							return customdesign.fn.notice(customdesign.i(24), 'notice', 3000);

						});

				}

			}

		},

		mobile : function(canvas_view) {
			
			var ww = $(window).width(),
				wh = $(window).height();
				
			if (canvas_view === true) {
				
				var main = customdesign.get.el('main'),
					stage = customdesign.stage(),
					mw = stage.canvas.width,
					mh = stage.canvas.height;
				
				main.css({transform: '', top: '', left: ''});
				
				if (ww<450 && stage.product.width > main.width()-20) {
					
					var rati = (main.width()-20)/stage.product.width,
						top = ((mh*rati)-mh);
						
					main.css({
						'transform': 'scale('+rati+')', 
						'top': top+'px', 
						'left': -(((mw-(main.width()-0))/2)*rati)+'px'
					});
					
					if (customdesign.data.rtl == '1') {
						main.css({
							'right': -(((mw-main.width())/2)*rati)+'px',
							'left': 'auto'
						});
						main.css({
							'left': main.css('left'),
							'right': 'auto'
						});
					}
					
				}
				
				return;
				
			};
			
			if (customdesign.ops.excmobile)
				return;
			
			customdesign.ops.window_width = ww;
				
			if (ww<1025) {
				
				$(window).on('scroll', function(e){
					e.stopPropagation();
					e.preventDefault();
					return false;
				});
				
				$(document.body).on('scroll touchEnd', function(e) {
					document.body.scrollTop = -1;
					e.preventDefault();
				});
				
				document.ontouchmove = function(event){
				    event.preventDefault();
				};
				
				setInterval(function() {document.body.scrollTop = -1;}, 500);
				
				$('#customdesign-left').on('mousedown touchstart touchend touchmove', function(e) {
					if (e.originalEvent.touches && e.originalEvent.touches.length > 1) {
						e.preventDefault();
						return true;
					}
				});
				
				$('#customdesign-main')
					.on('mousedown touchstart', function(e) {
					
					this.t = this.offsetTop;
					this.l = this.offsetLeft;
					this.x = e.originalEvent.pageX ? e.originalEvent.pageX : e.originalEvent.touches[0].pageX;
					this.y = e.originalEvent.pageY ? e.originalEvent.pageY : e.originalEvent.touches[0].pageY;
					this._do = ($('#customdesign-top-tools').attr('data-view') == 'standard');
					this._gest = this.gest;
					
					if (e.originalEvent.touches && e.originalEvent.touches.length === 2) {
						
						this.gest = true;
						
						if (!this.sc)
							this.sc = 1;
							
						this.a = e.originalEvent.touches[0].pageX - e.originalEvent.touches[1].pageX;
						this.b = e.originalEvent.touches[0].pageY - e.originalEvent.touches[1].pageY;
						
						this.scale_start = Math.sqrt((this.a*this.a) + (this.b*this.b));
						
					}else this.gest = false;
					
					this.start_move = true;
					
				})
					.on('mousemove touchmove', function(e) {
					
					if ((e.originalEvent.touches && e.originalEvent.touches.length === 1) || this.start_move !== true)
						return true;
					
					if (this.gest === true) {
						
						this.a = e.originalEvent.touches[0].pageX - e.originalEvent.touches[1].pageX;
						this.b = e.originalEvent.touches[0].pageY - e.originalEvent.touches[1].pageY;
						
						this.scale_move = Math.sqrt((this.a*this.a) + (this.b*this.b));
						
						this.scale = this.scale_move/this.scale_start;
						
						var sc = this.sc*this.scale;
						
						if (sc > 2) {
							sc = 2;
						}else if (sc < 0.5){
							sc = 0.5;
						};
						
						this.style.transform = 'scale('+sc+')';
						
					};
					
					if (this._do !== true) {
						e.preventDefault();
						return true;
					};
					
					this.style.top = (
						this.t+(
							(
								e.originalEvent.pageY ? 
								e.originalEvent.pageY : 
								e.originalEvent.touches[0].pageY
							)-this.y
						)
					)+'px';
					
					this.style.left = (
						this.l+(
							(
								e.originalEvent.pageX ? 
								e.originalEvent.pageX : 
								e.originalEvent.touches[0].pageX
							)-this.x
						)
					)+'px';
					
				})
					.on('mouseup touchend', function(e) {
					
					this.sc = parseFloat(this.style.transform.toString().replace('scale(', '').replace(')', ''));
						
					if (this.sc > 2) {
						this.sc = 2;
					}else if (this.sc < 0.5){
						this.sc = 0.5;
					};
					
					this.start_move = false;
					this.gest = false;
					
				});
				
				if (!localStorage.getItem('CUSTOMDESIGN-GUIDE')) {
					var img = $('<img id="mobile-guide" src="'+customdesign.data.assets+'assets/images/mobile-guide.jpg" />');
					$('body').append(img);
					img.on('click', function() {
						$(this).remove();
						localStorage.setItem('CUSTOMDESIGN-GUIDE', '{}');
					});
				}
				
			};
			
			if (ww<450) {
				
				customdesign.actions.add('first-completed', function(){
					$('li[data-tab="design"]').trigger('click');
				});
				
				var wrp = $('div#customdesign-left .customdesign-left-nav,#customdesign-top-tools');
				
				if ($('div#customdesign-left .customdesign-left-nav').width() < 450)
					var wrp = $('#customdesign-top-tools');
				
				wrp.on('mousedown touchstart', function(e){
					this.sub = $(e.target).closest('[data-view="sub"]');
					if (this.sub.length > 0)
						return true;
					this.l = this.offsetLeft;
					this.x = e.originalEvent.pageX ? e.originalEvent.pageX : e.originalEvent.touches[0].pageX;
					this.w = $(window).width();
					e.preventDefault();
				})
				.on('mousemove touchmove', function(e){
					if (this.sub !== undefined && this.sub.length > 0)
						return true;
					var l = (this.l+((e.originalEvent.pageX ? e.originalEvent.pageX : e.originalEvent.touches[0].pageX)-this.x));
					if (l > 0)
						l = l*0.1;
					else if (this.offsetWidth + l < this.w)
						l = (this.w - this.offsetWidth)+((l-(this.w - this.offsetWidth))*0.1);
					this.style.left = Math.round(l)+'px';
					e.preventDefault();
				})
				.on('mouseup touchend', function(e){
					
					if (this.sub !== undefined && this.sub.length > 0)
						return true;
					
					if (Math.abs(this.offsetLeft-this.l) <= 2)
						e.target.click();
					else if (this.offsetLeft > 0)
						$(this).animate({left: 0}, 150);
					else if (this.offsetWidth + this.offsetLeft < this.w)
						$(this).animate({left: -(this.offsetWidth-this.w)}, 150);
						
					e.preventDefault();
					
				});
				
				customdesign.actions.add('object:added', function(){
					$('li[data-tab="design"]').trigger('click');
					$('div#customdesign-left .customdesign-left-nav').css({left: '0px'});
				});
				customdesign.actions.add('selection:cleared', function(){
					$('#customdesign-top-tools').css({left: ''});
				});
				customdesign.actions.add('object:selected', function(){
					$('#customdesign-top-tools').css({left: ''});
				});
				customdesign.actions.add('after:render', function(){
					/*$('#customdesign-top-tools [data-tool].active').removeClass('active');*/
				});
				
				$('#customdesign-templates-list,#customdesign-cliparts-list').css({'max-height': (wh-224)+'px'});
				$('div#customdesign-left .customdesign-tab-body-wrp').css({height: (wh-110)+'px'});
				$('#customdesign-cart-wrp').css({'max-height': (wh - 200)+'px'});
				$('div#customdesign-left>div.customdesign-left-nav-wrp,div#customdesign-stage-nav').css({top: wh+'px'});
				$('#customdesign-left #customdesign-uploads div[data-tab]').css({height: (wh-169)+'px'});
				
			}else if (ww<1025) {
				
				$('#customdesign-main').on('touchstart', function(){
					$('#customdesign-side-close').trigger('click');
				});
				customdesign.actions.add('object:added', function(){
					$('#customdesign-side-close').trigger('click');
				});
				$('#customdesign-templates-list,#customdesign-cliparts-list').css({'max-height': (wh-170)+'px'});
				$('div#customdesign-left .customdesign-tab-body-wrp').css({height: (wh-54)+'px'});
				$('div#customdesign-stage-nav').css({top: (wh-30)+'px'});
				$('#customdesign-left #customdesign-uploads div[data-tab]').css({height: (wh-115)+'px'});
			};
			
			customdesign.ops.excmobile = true;
				
		},

		stage : function(){
			return customdesign.data.stages[customdesign.current_stage];
		},

		active_stage : function(name, callback) {
			
			if (typeof callback != 'function')
				callback = function(){};

			if (name === '')
				return callback();
				
			this.current_stage = name;

			if (!this.current_stage || !this.data.stages[this.current_stage])
				return alert(customdesign.i(20));
			
			var stage = this.data.stages[this.current_stage],
				nav = $('#customdesign-print-nav');
				
			stage.name = name;
			
			$('#customdesign-main div.customdesign-stage').hide();
			
			if ( stage.orientation !== undefined && stage.orientation !== '' ) {
				
				nav.find('select[name="orientation"]').val(stage.orientation);
				nav.find('li[data-row="orien"]').hide();
				
			} else nav.find('li[data-row="orien"]').show();
			
			if ( stage.size !== undefined && stage.size !== '' ) {
				
				if ( typeof stage.size == 'string' ) {
					
					if (nav.find('input[name="print-format"]:checked').attr('data-format') == 'png')
						nav.find('li[data-row="size"]').show();
					else nav.find('li[data-row="size"]').hide();
					
					nav.find('select[name="select-size"]').val(stage.size).attr({disabled: true});
					nav.find('input[name="size"]').val(stage.size);
					nav.find('input[data-unit="cm"]').prop({checked: true});
					nav.find('li[data-row="csize"],li[data-row="unit"]').hide();
				} else {
					nav.find('li[data-row="size"]').hide();
					nav.find('li[data-row="csize"],li[data-row="unit"]').show();
					nav.find('input[name="size"]').val(stage.size.width+' x '+stage.size.height).attr({disabled: true});
					nav.find('input[data-unit="'+stage.size.unit+'"]').prop({checked: true});
					nav.find('input[data-unit]').attr({disabled: true});
				}
				
			} else {
				
				nav.find('select[name="select-size"],input[name="size"],input[data-unit]').attr({disabled: null});
				nav.find('li[data-row="csize"],li[data-row="unit"],li[data-row="size"],li[data-row="orien"]').show();
				
				var pcfg = localStorage.getItem('CUSTOMDESIGN_PRINT_CFG');
				
				if (pcfg && pcfg !== '') {
					pcfg = JSON.parse(pcfg);
					if (pcfg.format !== undefined)
						nav.find('input[data-format="'+pcfg.format+'"]').prop({checked: true}).change();
					if (pcfg.unit !== undefined)
						nav.find('input[data-unit="'+pcfg.unit+'"]').prop({checked: true}).change();
					if (pcfg.size !== undefined)
						nav.find('select[name="select-size"]').val(pcfg.size).change();
					if (pcfg.csize !== undefined)
						nav.find('input[name="size"]').val(pcfg.csize).change();
				}
			};
			
			if (stage.canvas) {
				// the stage has been rendered
				if (stage.productColor != customdesign.get.color()) {
					stage.productColor.set('fill', customdesign.get.color());
				}

				customdesign.tools.discard();

				$('#customdesign-stage-'+name).show();

				if (stage.data) {
					
					customdesign.tools.import(stage.data, function(){
						customdesign.stack.save();
						customdesign.actions.do('active_stage', stage);
					});
					delete stage.data;
				} else customdesign.actions.do('active_stage', stage);;
				
				customdesign.fn.stage_nav(name, stage.product.width/stage.product.height);
				
				customdesign.mobile(true);
				
				return callback();

			};
			
			customdesign.f('Loading..');
			
			fabric.util.loadImage(stage.image, function(img) {
				
				customdesign.f(false);
				
			    if(img === null) {
			        customdesign.fn.notice(customdesign.i(33)+stage.image, 'error', 5000);
			    } else {
				    
					customdesign.fn.create_canvas(stage, img);
					
					stage.canvas.renderAll();
					
					customdesign.actions.do('render_stage', stage);
					
					if (stage.data) {
						var scale = (stage.data.product_height ? stage.product.height/stage.data.product_height : 1);
						customdesign.tools.import(stage.data, function(){
							if (scale !== 1)
								customdesign.fn.scale_designs(scale);
							customdesign.stack.save();
							customdesign.actions.do('active_stage', stage);
							callback();
						});
						delete stage.data;
					} else if(
						stage.template !== undefined && 
						stage.template.upload !== undefined &&
						stage.template.noload !== true
					) {
						customdesign.templates.load(stage.template, function() {
							customdesign.actions.do('active_stage', stage);
							callback();
						}); 
					} else {
						customdesign.stack.save();
						if (customdesign.ops.first_completed !== true) {
							customdesign.actions.do('first-completed');
							customdesign.ops.first_completed = true;
						};
						customdesign.actions.do('active_stage', stage);
						callback();
					}
				};
				
				customdesign.fn.stage_nav(name, stage.product.width/stage.product.height);
				
			});
			
		},

		cart : {

			data				: {},
			
			price				: {
				template : {},
				extra : {},
				base : 0,
				color: 0,
				attr : 0,
				fixed: 0
			},
			
			template			: {},
			
			qty					: 0,
			
			attr_tmpl			: null,
			
			timer				: null,
            
            /*
	        * @ Cart helper
            */
            			
			sum_calc			: function (){
				
				var prices = {},
					extra_filter = customdesign.apply_filters('product_extra_price', {}),
					price = customdesign.cart.price.base+customdesign.cart.price.color+customdesign.cart.price.attr;
				
				prices.base = price; 
				price = 0;
				
				// base price
				
				var ext_price = Object.values(extra_filter).filter(
					price => typeof price !== 'object' && parseFloat(price) > 0
				);
				
				if (ext_price.length > 0)
					price += ext_price.reduce((a, b) => parseFloat(a) + parseFloat(b));
				
				//calc extra price from addons
				
				if( Object.keys(customdesign.cart.price.extra).length > 0 ) {
					Object.values(customdesign.cart.price.extra).map(function (objs){
						objs.map(function (obj) {
							price += parseFloat(obj.price);
						});
					});
				}
				
				prices.ext = price; 
				price = 0;
				
				// price template
				
				price += (
					Object.keys(customdesign.cart.price.template).length > 0 &&
					Object.values(customdesign.cart.price.template).filter(price => parseFloat(price)).length > 0 ? 
					Object.values(customdesign.cart.price.template).
					   filter(price => parseFloat(price) >= 0).
					   reduce((a, b) => parseFloat(a) + parseFloat(b)) : 
					0
				);
				
				prices.template = price;
				
				return  prices;
				
			},
			
			sum					: function (){
				
				var price = this.sum_calc();
				
				return  price.base+price.ext+price.template;
				
			},
			
			extra_price			: function ( ext_id, data ) {
				
				if (data == null) {
					delete customdesign.cart.price.extra[ext_id];
					return;
				};
				
				if (typeof customdesign.cart.price.extra[ext_id] === 'undefined')
					customdesign.cart.price.extra[ext_id] = [];
					
				//check exists id of resource
				var f = customdesign.cart.price.extra[ext_id].filter(
					obj => obj.id == data.id && obj.table == data.table
				);
				
				if (typeof f[0] === 'undefined') 
					customdesign.cart.price.extra[ext_id].push(data);
					
			},
			
			get_price			: function (f){
				
				var price	= 0, 
					sum		= customdesign.cart.sum();
				
				if (isNaN(customdesign.cart.qty) || customdesign.cart.qty == 0)
					customdesign.cart.qty = 1;
					
				price = ( sum + customdesign.cart.printing.calc( customdesign.cart.qty ) ) * customdesign.cart.qty;
				
				price += customdesign.cart.price.fixed;
				
				return f === true ? [price, customdesign.cart.qty] : price;
				
			},

			init				: function () {

				if(customdesign.onload == undefined)
					customdesign.cart.render();
					
				/*
					update printing price when objects changed
				*/
				customdesign.actions.add('updated', function (data){
					
					clearTimeout(customdesign.cart.timer);
					
					customdesign.cart.timer = setTimeout(function (){
						customdesign.cart.calc(data);
					}, 300);
					
				});
				
				customdesign.actions.add('checkout', customdesign.cart.checkout);

				$('#customdesign-cart-action').on('click', function(e){
					
					customdesign.cart.add_cart('button add cart click');
					
					e.preventDefault();
				});
				
				if (top.location !== window.location) {
					$('#back-btn a').on('click', function(e) {
						top.location.href = this.getAttribute('href');
						e.preventDefault();
					});	
				};

				customdesign.render.cart_change();
				
			},
			
			add_cart			: function(e) {
				
				if (customdesign.fn.url_var('product_cms', '') == '0') {
					alert('Could not add to cart, missing product_cms id');
					return;
				}
				
				var invalid_fields	= [], 
					has_design		= 0,
					invalids		= [],
					inv				= null,
					attrs			= $('.customdesign-cart-attributes');
			
				/*
				*	Check cart_design empty
				*/
				
				Object.keys(customdesign.data.stages).map(function(s) {
					if (
						typeof customdesign.data.stages[s] !== 'undefined'
					) {
						if (
							customdesign.data.stages[s].canvas !== undefined
						){
							var canvas = customdesign.data.stages[s].canvas,
								objs = canvas.getObjects();
							
							if (
								objs.filter(function(o) {
									return o.evented === true;
								}).length > 0
							) {
								has_design++;
							}
							
						} else if (
							customdesign.data.stages[s].data !== undefined &&
							customdesign.data.stages[s].data.objects !== undefined
						) {
							if (
								customdesign.data.stages[s].data.objects.filter(function(o) {
									return o.evented === true;
								}).length > 0
							) {
								has_design++;
							}
						}
					}
				});
				
				if (
					has_design === 0
				) {
					customdesign.fn.notice(customdesign.i(96), 'error');
					delete cart_data;
					delete cart_design;
					return false;
				};
				
				if (
					customdesign.data.required_full_design == '1' &&
					has_design < Object.keys(customdesign.data.stages).length
				) {
					customdesign.fn.notice(customdesign.i(210), 'error');
					delete cart_data;
					delete cart_design;
					return false;
				};
				
				/*
				*	Check printing
				*/
				
				if(
					customdesign.data.printings.length > 0 && 
					customdesign.cart.printing.current === null
				){
					inv = $('.customdesign-prints').find('.customdesign-cart-field-printing-tmpl').get(0);
					if (inv !== undefined)
						invalid_fields.push(inv);
					$('.customdesign-prints').find('.customdesign-cart-field-printing-tmpl .customdesign-required-msg').html(customdesign.i(99));
				};
					
				attrs.find('em.customdesign-required-msg').remove();
				attrs.find('.customdesign-cart-param').each(function (ind) {
					
					var field	= $(this),
						name	= field.attr('name'),
						type	= field.attr('type'),
						found	= false;
					
					if (field.prop('required')) {
						if(
							(
								(
									(type == 'radio' || type == 'checkbox') &&
									field.closest('.customdesign-cart-field').find('[name="'+name+'"]:checked').length === 0
								) 
								|| 
								this.value === ''
							)
							&&
							invalids.indexOf(name) === -1
						){
							invalids.push(name);
							invalid_fields.push(field.closest('.customdesign-cart-field')[0]);
							field.after(
								'<em class="customdesign-required-msg">'+
								customdesign.i(102)+
								'</em>'
							).closest('.customdesign_form_group').shake();
						}
            		}
				});
				
				if (invalid_fields.length > 0) {
					
					var wrp = $('#customdesign-cart-wrp'),
						pos = invalid_fields[0].offsetTop;
					
					if (wrp.closest('#customdesign-product').length > 0) {
						$('#customdesign-left .customdesign-left-nav li[data-tab="product"]').trigger('click');
						$('#customdesign-product').show().animate({scrollTop: pos - 20}, 400);
					} else wrp.animate({scrollTop: pos - 20}, 400);
					
					customdesign.fn.notice(customdesign.i(179), 'error', 3500);
					
					delete cart_data;
					delete cart_design;
					return false;
					
				};
				
				try {
					var vari = customdesign.ops.product_data.variations.variations[customdesign.data.variation];
					if (parseFloat(customdesign.cart.qty) < parseFloat(vari.minqty)) {
						customdesign.fn.notice(customdesign.i(149)+" <br>(Variation #"+customdesign.data.variation+" has min quantity are "+vari.minqty+")", 'error', 5000);
						return;
					} else if (parseFloat(customdesign.cart.qty) > parseFloat(vari.maxqty)) {
						customdesign.fn.notice(customdesign.i(150)+" <br>(Variation #"+customdesign.data.variation+" has max quantity are "+vari.maxqty+")", 'error', 5000);
						return;
					}
				} catch(ex) {};
				
				/*
				*
				*	END OF VALID OPTIONS
				*
				*/
				
				var cart_design			= customdesign.fn.export('cart'),
					start_render 		= 0,
					current_stage		= customdesign.current_stage,
					first_stage 		= Object.keys(customdesign.data.stages)[start_render],
					export_print_file 	= function(s) {
						
						start_render++;
						
						customdesign.active_stage(s, function() {
							
							$('#CustomdesignDesign').attr({
								'data-processing': 'true',
								'data-msg': customdesign.i('render')
							});
								
							customdesign.get.el('zoom').val('100').trigger('input');
							
							customdesign.fn.uncache_large_images(function() {
									
								let psize = customdesign.get.size();
								
								customdesign.f(false);
								
								customdesign.fn.download_design({
									type: 'png',
									orien: psize.o,
									height: psize.h,
									width: psize.w,
									include_base: false,
									with_base: customdesign.data.stages[s].include_base,
									callback: function(data) {
										
										customdesign.fn.uncache_large_images(null, true);
										
										cart_design.stages[s].print_file = data;	
										
										if (Object.keys(customdesign.data.stages)[start_render] !== undefined) {
											export_print_file (Object.keys(customdesign.data.stages)[start_render]);
										} else {
											customdesign.active_stage(current_stage);
											return customdesign.cart.process_add_cart(cart_design);
										}
										
									}	
								});
							
							}); /* End uncache */
							
						});
							
					};
				
				$('#CustomdesignDesign').attr({'data-processing': 'true', 'data-msg': 'Preparing cart data'});
				
				export_print_file(first_stage);
				
				if (e !== undefined && typeof e.preventDefault == 'function')
					e.preventDefault();
				
				
			},
			
			process_add_cart	: function(cart_design) {
				
				customdesign.f(false);
						
				var values			= [],
					id				= customdesign.fn.url_var('cart', new Date().getTime().toString(36).toUpperCase()),
					cart_data		= JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA') || '{}');
				
				cart_data[id] = {
					id			: id,
				    screenshot	: '',
					stages		: 0,
					name		: customdesign.ops.product_data.name,
					updated		: new Date().getTime(),
					product		: customdesign.ops.product_data.id,
					product_cms : customdesign.ops.product_data.product,
					printing	: customdesign.cart.printing.current,
					printings_cfg : customdesign.data.printings_cfg,
					options		: $.extend(true, {}, customdesign.cart.data.options),
					attributes	: $.extend(true, {}, customdesign.ops.product_data.attributes),
					price_total	: customdesign.cart.get_price(),
					extra		: $.extend(true, {}, customdesign.cart.price.extra),
				    states_data : $.extend(true, {}, customdesign.cart.printing.states_data),
				    variation	: customdesign.data.variation,
					template	: {
						'stages'	: customdesign.cart.template,
						'price'		: customdesign.cart.price.template
					},
					system_version : customdesign.data.version
				};
				
				Object.keys(customdesign.data.stages).map(function(s) {
					cart_data[id].stages++;
					if (cart_data[id].screenshot === '')
						cart_data[id].screenshot = customdesign.data.stages[s].image;
				});
				
				Object.keys(customdesign.cart.data.options).map(function (i){
					values.push(customdesign.cart.data.options[i]);
				});
				
				
				customdesign.cart.qty = parseInt(customdesign.cart.qty);
				
				if (isNaN(customdesign.cart.qty) || customdesign.cart.qty == 0) 
					customdesign.cart.qty = 1;
				
				cart_data = customdesign.apply_filters('cart_data', cart_data);
				cart_design = customdesign.apply_filters('cart_design', cart_design);
				
				localStorage.setItem('CUSTOMDESIGN-CART-DATA', JSON.stringify(cart_data));
				
				cart_design.id = id;
				customdesign.indexed.save([cart_design], 'cart');
				
				delete cart_design;
				delete cart_data;
				
				customdesign.render.cart_confirm();
				customdesign.render.cart_change();
				customdesign.actions.do('add-cart', id); 
		
				return true;
				
			},
			
			variations			: function(el) {
				
				if (customdesign.data.variations.attrs === undefined || customdesign.data.variations.attrs.indexOf(el.name) === -1)
					return;
				
				var values = {};
				
				$('.customdesign-cart-attributes .customdesign-cart-param:not(.disabled)').serializeArray().map(function(x){
					values[x.name] = x.value;
				});
				
				var vari_data = customdesign.fn.process_variations(values, el);
				
				// no variations change
				if (
					(
						vari_data.variation === null && 
						customdesign.data.variation === null
					) ||
					customdesign.data.variation == vari_data.variation
				) return customdesign.render.product_attrs(vari_data);
				
				customdesign.data.variation = vari_data.variation;
				
				if (vari_data.cfgprinting)
					customdesign.data.printings_cfg = vari_data.printings_cfg;
				else customdesign.data.printings_cfg = customdesign.ops.product_data.printings_cfg;	
				
				customdesign.data.printings = vari_data.printings;
				
				customdesign.render.product_attrs(vari_data);
				
				if (vari_data.cfgstages !== true && customdesign.data.cfgstages !== true)
					return; // no cfgstages 
				
				customdesign.data.stages = customdesign.fn.keep_current_designs(vari_data.stages);
				customdesign.data.cfgstages = vari_data.cfgstages;
				
				customdesign.get.el('main').find('.customdesign-stage,#customdesign-no-product').remove();
				
				customdesign.active_stage(customdesign.render.stage_nav(), customdesign.cart.calc);
				
				customdesign.actions.do('product-variation', vari_data);
				
			},
			
			calc				: function (states_data) {
				
				if (states_data == undefined)
					states_data = customdesign.cart.printing.states_data;
				else
					customdesign.cart.printing.states_data = states_data;
					
				customdesign.cart.data = {
					options : {},
					printing : customdesign.cart.printing.current,
					states_data : customdesign.cart.printing.states_data
				};
				
				customdesign.cart.price.attr = 0;
				customdesign.cart.price.fixed = 0;
				customdesign.cart.qty = 0;
				
				var fields = $('.customdesign-cart-attributes .customdesign-cart-param:not(.disabled)').serializeArray(),
					attrs = customdesign.ops.product_data.attributes;
				
				fields.map(function (field){
					
					if (attrs[field.name] == undefined) 
						return;
						
					var attr = attrs[field.name];

					if (field.value === '') {
						delete customdesign.cart.data.options[attr.id];
					} else {
						if (customdesign.cart.data.options[attr.id] === undefined)
							customdesign.cart.data.options[attr.id] = field.value;
						else customdesign.cart.data.options[attr.id] += "\n"+field.value;
					};
					
					if (attr.type == 'quantity') {
						
						if ( !isNaN(parseInt(field.value)) ) {
							
							customdesign.cart.qty += parseInt(field.value);
							
							if (
								attr.values !== undefined &&
								typeof attr.values == 'object' &&
								attr.values.type == 'package'
							) {
								
								var attr_price = attr.values.package_options.filter(function(o) {
									return o.value == field.value;
								});
								// calc attr price for quantity group
								if (
									attr_price.length > 0 && 
									attr_price[0].price !== '' && 
									!isNaN(parseInt(attr_price[0].price))
								) {
									customdesign.cart.price.attr += parseFloat(attr_price[0].price);
								}
							}
							
						} else if ( field.value !== '' && attr.values.type == 'multiple') {
							
							try {
								
								var qtys = JSON.parse(field.value);
								
								Object.keys(qtys).map(function(i) {
									
									if ( !isNaN(parseInt(qtys[i])) ) {
										
										customdesign.cart.qty += parseInt(qtys[i]);
										
									}
								});
								// Calc attr price for multiple quantity 
								Object.keys(qtys).map(function(i) {
										
									var attr_price = attr.values.multiple_options.filter(function(o) {
										return o.value == i;
									});
									
									if (
										attr_price.length > 0 && 
										attr_price[0].price !== '' && 
										!isNaN(parseInt(attr_price[0].price)) &&
										!isNaN(parseInt(qtys[i]))
									) {
										customdesign.cart.price.fixed += parseFloat(attr_price[0].price)*parseInt(qtys[i]);
									}
									
								});
									
							} catch (ex) {}
							
						}
						
					} else if (typeof attr.values == 'object' && typeof attr.values.options == 'object') {
						
						var attr_price;
						
						field.value.split(decodeURI("%0A")).map(function(v) {
							
							if (v === '')
								return;
								
							attr_price = attr.values.options.filter(function(o) { 
									return o.value == v; 
								});
							
							if (
								attr_price.length > 0 && 
								attr_price[0].price !== '' && 
								!isNaN(parseInt(attr_price[0].price))
							) {
								customdesign.cart.price.attr += parseFloat(attr_price[0].price);
							}
							
						});
						
					}
					
				});
				
				customdesign.cart.price.template = {};
				
				Object.keys(customdesign.data.stages).map(function(s){
					
					if (typeof customdesign.data.stages[s].canvas !== 'undefined'){
					
						var canvas = customdesign.data.stages[s].canvas;
						
						customdesign.cart.template[s] = [];
						customdesign.cart.price.template[s] = 0;
						
						canvas.getObjects().map(function (obj){
							
							if (obj.evented == true) {
								if (obj.price !== undefined && parseFloat(obj.price) > 0)
									customdesign.cart.price.attr += parseFloat(obj.price);
							}
							
							if (
								obj.template !== undefined && 
								typeof obj.template == 'object' &&
								customdesign.cart.template[s].indexOf(obj.template[0]) === -1
							) {
								customdesign.cart.template[s].push(obj.template[0]);
								customdesign.cart.price.template[s] += obj.template[1];
							}
							
						});
						
					}
				});
				
				/*
				*	Don't auto change quantity by variation, 
				*	will notice error when add to cart if dont valid min-max qty of variation
				*
				try {
					var vari = customdesign.ops.product_data.variations.variations[customdesign.data.variation];
					if (parseFloat(customdesign.cart.qty) < parseFloat(vari.minqty))
						customdesign.cart.qty = parseFloat(vari.minqty);
					if (parseFloat(customdesign.cart.qty) > parseFloat(vari.maxqty))
						customdesign.cart.qty = parseFloat(vari.maxqty);
				} catch(ex) {};
				*/
				
				if (customdesign.cart.qty === 0)
					customdesign.cart.qty = 1;
				
				customdesign.actions.do('cart-calc');	
				customdesign.cart.display();
				
			},
			
			checkout			: function(data) {
				
				var items = [],
					formData = new FormData(),
					blob = '',
					upload_size = 100;
				
				formData.append('action', 'checkout'); 
				formData.append('ajax', 'frontend'); 
				formData.append('nonce', 'CUSTOMDESIGN-SECURITY:'+customdesign.data.nonce); 
				
	            Object.keys(data).map(function(key) {
	                
	                data[key].product_id = data[key].product;
	                
	                if(data[key].product_cms !== '' )
	                    data[key].cms_id = data[key].product_cms;
	                else
	                    data[key].cms_id = 0;
	                    
	                data[key].product_name = data[key].name;
	                
	                blob = JSON.stringify(customdesign.apply_filter('checkout-item', data[key]));
					 upload_size += blob.length;
					
	                formData.append(key, new Blob([blob]));
	                
	            });
	            
	            delete data;
	            
	            if (customdesign.data.max_upload_size > 0 && upload_size/1024000 > customdesign.data.max_upload_size) {
		            customdesign.fn.notice('Error: your design is too large ('+(upload_size/1024000).toFixed(2)+'MB out of max '+customdesign.data.max_upload_size +'MB)<br>Please contact the administrator to change the server configuration', 'error', 5000);
		            return customdesign.f(false);
	            }
	            
	            customdesign.f('0% complete');
					
				 $.ajax({
				    data	:	 formData,
				    type	:	 "POST",
				    url		:	 customdesign.data.ajax,
				    contentType: false,
				    processData: false,
				    xhr		:	 function() {
					    var xhr = new window.XMLHttpRequest();
					    xhr.upload.addEventListener("progress", function(evt){
						    
						    if (evt.lengthComputable) {
						        var percentComplete = evt.loaded / evt.total;
						        if (percentComplete < 1)
						       		$('div#CustomdesignDesign').attr({'data-msg': parseInt(percentComplete*100)+'% upload complete'});
						        else $('div#CustomdesignDesign').attr({'data-msg': customdesign.i(159)});
						    }
						    
					    }, false);
					    return xhr;
					},
				    success: function (res, status) {
					    
					    $('div#CustomdesignDesign').attr({'data-msg': customdesign.i(161)});
					    
					    if (res == '0') {
						    alert('Error: could not checkout this time');
					    } else {
						    res = customdesign.apply_filters('checkout-success', res);
						    if (
						    	res !== false &&
						    	typeof res == 'string'
						    ) {
							    top.location.href = res;
						    } else {
							    console.error(res);
						    }
						}
				    },
				    error: function() {
					    alert('Error: could not checkout this time');
				    }
				});

				return; 
				
				
				
				
				var boundary = "---------------------------7da24f2e50046";
				var body = '--' + boundary + '\r\n'
				         + 'Content-Disposition: form-data; name="file";'
				         + 'filename="temp.txt"\r\n'
				         + 'Content-type: plain/text\r\n\r\n'
				         + data + '\r\n'+ '--'+ boundary + '--';
				       
				$.ajax({
				    contentType: "multipart/form-data; boundary="+boundary,
				    data: body,
				    type: "POST",
				    url: customdesign.data.ajax+'&action=upload&ajax=frontend&nonce=CUSTOMDESIGN-SECURITY:'+customdesign.data.nonce,
				    xhr: function() {
					    var xhr = new window.XMLHttpRequest();
					    xhr.upload.addEventListener("progress", function(evt){
					      if (evt.lengthComputable) {
					        var percentComplete = evt.loaded / evt.total;
					        if (percentComplete < 1)
					       		$('div#CustomdesignDesign').attr({'data-msg': parseInt(percentComplete*100)+'% upload complete'});
					       	else $('div#CustomdesignDesign').attr({'data-msg': customdesign.i(159)});
					      }
					    }, false);
					    return xhr;
					},
				    success: function (res, status) {
					    
					    $('div#CustomdesignDesign').attr({'data-msg': customdesign.i(161)});
					    
					    res = JSON.parse(res);
					    
					    if (res.success !== undefined) {
						    $('<form>', {
				                "id": "customdesign-checkout",
				                "method": "POST",
				                "html": '<input type="hidden" name="file" value="'+res.success+'"/>\
				                		 <input type="hidden" name="datalen" value="'+data.length+'"/>\
				                		 <input type="hidden" name="action" value="process"/>\
				                		 <input type="hidden" name="nonce" value="CUSTOMDESIGN-SECURITY:'+customdesign.data.nonce+'"/>',
				                "action": customdesign.data.checkout_url
				            }).appendTo(document.body).submit();
					    } else {
						    alert('Error: could not checkout this time');
					    }
				    },
				    error: function() {
					    alert('Error: could not checkout this time');
				    }
				});
	            
	        },
			
			/*
			* @param data - Product object
			*/

			render				: function (data) {
				
				var attr = {},
					wrp = customdesign.get.el('cart-attributes');
				
				wrp.html('');
				
				if (data === undefined)
					return;
					
				customdesign.cart.printing.render(data.printing);
				
				customdesign.cart.price.base = parseFloat(data.price);
				
				var cart = localStorage.getItem('CUSTOMDESIGN-CART-DATA'),
					cur = customdesign.fn.url_var('cart', '');
				
				if (cart !== '')
					cart =  JSON.parse(cart);
				else cart = {};
				
				/*
				* Render ext attributes (e.g: woocommerce product variation)
				*/
				
				if (
					data.ext_attributes !== undefined &&
					({}).constructor === data.ext_attributes.constructor
				) {
					
					let arr;
					
					for (n in data.ext_attributes) {
						
						arr = {
							id: n.toLowerCase(),
							classes: 'ext-attribute',
							type: 'select',
							required: true,
							name: n,
							value: data.ext_attributes_value[n.toLowerCase()],
							values: {
								options: []
							}
						};
						
						Object.values(data.ext_attributes[n]).forEach((i) => {
							arr.values.options.push({
								value: i,
								price: '',
								title: i	
							});
						});
						
						wrp.append(customdesign.cart.fields.render(arr));
						
					};
					
				};
				
				
				Object.keys(data.attributes).map(function (k){
					
					var attr = data.attributes[k];
					
					customdesign.ops.product_data.attributes[k].allows = attr.allows;
					
					if (attr.value === undefined) {
						if (typeof attr.values == 'object' && typeof attr.values.options == 'object') {
							attr.value 	= [];
							attr.values.options.map(function(o) {
								if (o.default === true)
									attr.value.push(o.value);
							});
							attr.value = attr.value.join(decodeURI("%0A"));
						} else if (typeof attr.values == 'object' && attr.values.default !== undefined) {
							attr.value = attr.values.default;
						} else attr.value 	= '';
					};
					
					if (attr.id === undefined)	
						attr.id = customdesign.cart.slug(attr.name);
					
					wrp.append(customdesign.cart.fields.render(attr));
					
				});
				
				if (customdesign.data.calc_formula == '1') {
					wrp.append(
						'<div class="customdesign-cart-field how-calculate">\
							<a href="#formula">\
								'+customdesign.i(180)+'\
								<i class="customdesignx-ios-arrow-forward"></i>\
							</a>\
						</div>'
					)
				};
				
				customdesign.trigger({
					el: wrp,
					events : {
						'.customdesign-cart-param:change' : 'calc_cart',
						'a[href="#formula"]': 'formula'
					},
					calc_cart : function (e){
						
						// hash : 2cca8dcd607566aec4da56227019f71f
						// make sesion local variable save satate dropdown change
						
						sessionStorage.setItem('CUSTOMDESIGN-PRINT-DROPDOWN', 'false');
						
						$('#customdesign-cart-attributes em.customdesign-required-msg').remove();
						
						customdesign.cart.variations(this);
						customdesign.cart.calc();
						
						customdesign.render.cart_change();
						customdesign.actions.do('cart-changed', true);
						
					},
					formula : function(e) {
						
						e.preventDefault();
						
						var sum = customdesign.cart.sum_calc(),
							table = '',
							print_detail = false;
							
						if (customdesign.data.printings.length > 0) {
							
							var print = customdesign.data.printings.filter(function(p) {
									return p.id == customdesign.cart.printing.current;
								});
							
							print_detail = (
								print.length > 0 && (
									print[0].description !== '' || 
									(
										typeof print[0].calculate['show_detail'] !== 'undefined' && 
										print[0].calculate.show_detail == 1
									)
								) && 
								customdesign.cart.printing.calc(customdesign.cart.qty) > 0
							) ? true : false;
							
						};
						
						var varitxt = '', 
							vr = (
									customdesign.ops.product_data.variations !== undefined && 
									customdesign.ops.product_data.variations.variations !== undefined &&
									customdesign.ops.product_data.variations.variations[customdesign.data.variation] !== undefined
								 ) ? customdesign.ops.product_data.variations.variations[customdesign.data.variation] : null;
						
						if (customdesign.data.variation !== null && vr !== null) {
							varitxt += '<p class="notice">'+
										customdesign.i(193)+' <strong>#'+customdesign.data.variation+'</strong>'+
										(vr.price !== '' ? ', '+customdesign.i(182)+': <strong>'+vr.price+'</strong>' : '')+
										(vr.minqty !== '' ? ', min-qty: <strong>'+vr.minqty+'</strong>' : '')+
										(vr.maxqty !== '' ? ', max-qty: <strong>'+vr.maxqty+'</strong>' : '')+
										'</p>';
						}
						
						var item_price = sum.ext+sum.base+sum.template+customdesign.cart.printing.calc(customdesign.cart.qty);
						
						customdesign.tools.lightbox({
							content: '<div class="customdesign_content customdesign_wrapper_table">\
								<h3 class="title">'+customdesign.i(180)+'</h3>\
								<div id="customdesign-formula-detail">\
									'+varitxt+'\
									<table>\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(182)+'</td>\
											<td>'+customdesign.fn.price(sum.base-customdesign.cart.price.attr)+'</td>\
										</tr>\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(199)+'</td>\
											<td>'+customdesign.fn.price(customdesign.cart.price.attr)+'</td>\
										</tr>\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(91)+'</td>\
											<td>'+customdesign.fn.price(sum.template)+'</td>\
										</tr>\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(108)+'</td>\
											<td>'+
												customdesign.fn.price(customdesign.cart.printing.calc(customdesign.cart.qty))+
												(
													print_detail ? 
													' &nbsp; <a href="#" data-print="'+print[0].id+'">'+
														customdesign.i(68)+
														' <i class="customdesignx-android-open"></i></a>' : ''
												)+
												'</td>\
										</tr>\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(183)+'</td>\
											<td>'+customdesign.fn.price(sum.ext)+'</td>\
										</tr>\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(74)+'</td>\
											<td>'+customdesign.fn.price(item_price)+' x '+
												customdesign.cart.qty+'qty = <strong>'+customdesign.fn.price(item_price*customdesign.cart.qty)+'</strong></td>\
										</tr>\
										'+(customdesign.cart.price.fixed !== 0 ? '\
										<tr>\
											<td style="width:20%;text-align: left">'+customdesign.i(198)+'</td>\
											<td>'+customdesign.i(74)+' + '+customdesign.fn.price(customdesign.cart.price.fixed)+' = <strong>'+customdesign.fn.price((item_price*customdesign.cart.qty)+customdesign.cart.price.fixed)+'</strong></td>\
										</tr>\
										' : '')+'\
									</table>\
								</div>\
							</div>'
						});
						
						$('#customdesign-formula-detail a[data-print]').on('click', function(e) {
							e.preventDefault();
							customdesign.fn.print_detail(this.getAttribute('data-print'));
						});
						
					}
				});
				
				if (typeof data.ext_attributes_callback == 'string') {
					try {
						let ext_callback = new Function('wrp', data.ext_attributes_callback);
						ext_callback(wrp);
					} catch (ex){
						console.log(ex);
					}
				};
				
				customdesign.cart.calc();
				
				customdesign.trigger({
					el : $('.customdesign-add-cart-btn'),
					events : {
						':click' : 'submit_cart'
					},
					submit_cart : function (e){
						var form = $('#customdesign-cart-form');

						form.find('input[name=data]').val(JSON.stringify(customdesign.cart.data));
						form.find('input[name=product]').val(customdesign.data.product);
						form.submit();
					}
				});
				
				customdesign.actions.do('cart-render', wrp);

			},

			validate_file		: function(file) {
				
				if (
					[
						'image/png', 
						'image/jpeg', 
						'image/gif', 
						'image/svg+xml', 
						'application/zip', 
						'text/plain', 
						'.docx'
					].indexOf(file.type) === -1
				)
					return false;
				
				if (file.size > 5242880)
					return false;
				
				return true;
				
			},

			slug				: function (str, decode){
				if(decode == undefined)
					return encodeURIComponent(str);
				else
					return decodeURIComponent(str);
			},

			fields				: {
				
				render : function(data) {
					
					var lac = customdesign.data.attributes_cfg[data.type];
					
					if (lac === undefined || lac.render === undefined || lac.render === '')
						return '';
					
					if (typeof lac.frontend_render != 'function') {
						try {
							lac.frontend_render = Function("data", "$", "customdesign", lac.render);
						} catch (ex) {
							return $('<p>JS Error: field render <b>'+data.type+'</b> :: '+ex.message+'</p>');
						}
					};
					
					if (data.type == 'quantity')
						data.required = true;
					
					if (typeof data.value == 'object')
						data.value = data.value[0];
					
					let values = data.values;
					
					if (typeof data.values == 'string') {
						try {values = JSON.parse(data.values);}catch (ex) {};
					};
					
					if (data.use_variation === true) {
						data.required = true;
						data.values = {options: [{value: '', title: customdesign.i(178), price: ''}]};
					};
					
					if (
						data.use_variation === true &&
						typeof data.allows == 'object' && 
						typeof values == 'object' && 
						typeof values.options == 'object' && 
						values.options.length > 0
					) {
						data.values.options = [];
						values.options.map(function(op) {
							if (
								data.allows.indexOf(op.value) > -1
							) data.values.options.push(op);
						});
					};
					
					if (data.id === undefined)
						data.id = encodeURIComponent(data.name);
					
					var field = $('<div data-type="'+data.type+'" data-id="'+(
								data.id !== undefined ? data.id : ''
							)+'" class="customdesign-cart-field field-inline'+(
								data.classes !== undefined ? ' '+data.classes : ''
							)+'">\
							<div class="customdesign_form_group">\
								<span class="customdesign-cart-field-label">'+
									(data.name)+': '+
									(data.required ? ' <em class="required">*</em>' : '')+'\
								</span>\
								<div class="customdesign_form_content"></div>\
							</div>\
						</div>'),
						inp = lac.frontend_render(data, $, customdesign);
					
					field.find('div.customdesign_form_content').append(inp);
					
					return field;

				},
				
				printing : function (data){
					
					var field_tpml = $('<div class="customdesign_radios">\
										<div class="customdesign-radio">\
				                			<input type="radio" class="customdesign-cart-param" name="printing" value="1" id="" required>\
							                <label class="customdesign-cart-option-label" for=""></label>\
							            </div>\
									</div>'),
						label = field_tpml.find('.customdesign-cart-field-label'),
						inp = field_tpml.find('.customdesign-cart-param');

					label.html((data.label ? data.label : data.title)+': '+(data.required ? '<em class="required">*</em>' : '') + ' <em class="customdesign-required-msg"></em>');

					inp.attr('name', data.name);
					
					if(!data.required) inp.removeAttr("required");
					
					return {el: field_tpml, inp:inp, label : label};
				}
				
			},

			display				: function () {
				
				var price = customdesign.cart.get_price(true);
				
				$('.customdesign-product-price').html(
					customdesign.fn.price(price[0].toFixed(2))
				);
				$('#customdesign-product-attributes .customdesign-product-price').append(
					'<avg>\
						<strong>'+
						customdesign.i(156)+
						':</strong> '+
						(customdesign.fn.price((price[0]/price[1]).toFixed(1)))+'/'+customdesign.i(157)+
					'</avg>'
				);
			},

	        printing			: {

				price : 0,

				states_data : {},

				current : null,

				render : function (active){
					
					customdesign.cart.printing.price = 0;
					customdesign.cart.printing.current = active ? active : null;
					
					$('#customdesign-cart-wrp .customdesign-prints').html('');
					if (!customdesign.data.printings || customdesign.data.printings.length === 0)
						return;
						
					var wrp	 = $('<div class="customdesign-cart-field">\
						<div class="customdesign_form_group">\
							<span class="customdesign-cart-field-label">'+customdesign.i(64)+' <em class="required">*</em></span>\
							<div class="customdesign_form_content">\
								<div class="customdesign_radios"></div>\
							</div>\
						</div>\
					</div>');
					
					customdesign.data.printings.map(function (print, index){
						
						print.thumbnail =  print.thumbnail || customdesign.data.assets + 'assets/images/print-default.jpg';
						
						var id = 'customdesign-printing-' + print.id,
							show_link = (
								print.description !== '' || 
								(
									typeof print.calculate['show_detail'] !== 'undefined' && 
									print.calculate.show_detail == 1
								)
							) ? true : false,
							new_op 	= $('<div class="customdesign-radio">\
	                			<input type="radio" class="customdesign-cart-param" name="printing" value="'+print.id+
	                				'" data-id="'+print.id+'" id="'+id+'" required>\
				                <label class="customdesign-cart-option-label" for="'+id+'">\
				                	<div class="customdesign-cart-option-thumb">\
				                		<img src="'+print.thumbnail+'" alt="" />\
				                	</div>\
									<div class="customdesign-desc">\
										<span>' + print.title + '</span>' +
										( show_link ? ' <a href="#" class="customdesign-color customdesign-print-detail" data-id="'+
											print.id+'">'+ customdesign.i(68) +'</a>' : '')+'</div>\
				                </label>\
							</div>');
						
						customdesign.trigger({
							el : new_op,
							events : {
								'a.customdesign-print-detail' : 'price_table',
								'input:change' : 'select_printing',
							},
							price_table : function (e){
								
								e.preventDefault();
								
								customdesign.fn.print_detail(this.getAttribute('data-id'));
								
							},
							select_printing : function (e){
								customdesign.cart.printing.current = parseInt($(this).val());
								customdesign.cart.calc();
							}
						});

						// hash : 2cca8dcd607566aec4da56227019f71f
						//if dropdown change first item selected
						if(sessionStorage.getItem("CUSTOMDESIGN-PRINT-DROPDOWN") === 'false'){
							customdesign.cart.printing.current = parseInt(print.id);
							customdesign.cart.calc();
							sessionStorage.setItem('CUSTOMDESIGN-PRINT-DROPDOWN', 'true');
						}

						wrp.find('div.customdesign_radios').append(new_op);

						if (print.active === true)
							customdesign.cart.printing.current = print.id;
							
					});
					
					$('.customdesign-prints').append(wrp);
					
					if (customdesign.cart.printing.current === null && customdesign.data.printings.length > 0) {
						customdesign.data.printings[0].active = true;
						customdesign.cart.printing.current = customdesign.data.printings[0].id;
					}
						
					if (customdesign.cart.printing.current !== null)
						$('#customdesign-printing-'+customdesign.cart.printing.current).trigger('click');

				},

	            calc : function (qty) {
		            
	                if(
						customdesign.data.printings.length == 0 ||
						customdesign.cart.printing.current == null
					) return 0;
					
	                var print = null,
						rules = {},
						stage = '',
	                    qtys = [],
	                    rule = [],
	                    price = 0,
						colors = [],
						states_data = customdesign.cart.printing.states_data,
						print_type = '',
						index = -1,
						total_res = 0;

					var match_print = customdesign.data.printings.filter(function (p){
						return (customdesign.cart.printing.current == p.id);
					});
					
					if (match_print.length > 0) {
						
						print = match_print[0];
						
						if (typeof print.calculate == 'string')
							print.calculate = customdesign.fn.dejson(print.calculate);
							
						print_type = print.calculate.type;
						rules = print.calculate.values;
						
					} else return 0;
					
					if	(typeof rules === 'undefined') 
						return 0;
					
					var indx = 0;
					
                    for (var s in states_data){

						stage = indx;

						if(!print.calculate.multi){
							stage = 0;
						}
						
						stage = Object.keys(rules)[stage];
                        qtys = rules[stage] ? Object.keys(rules[stage]) : [];
						
						if(qtys.length == 0) continue;

						qtys.sort(function(a, b){return parseInt(a)-parseInt(b)});

						for (var i=0; i < qtys.length; i++){
							if(
								(
									!isNaN(qtys[i]) && 
									parseInt(qtys[i]) < qty
								) ||
								
								(
									isNaN(qtys[i]) &&
									qtys[i].indexOf('>') > -1 &&
									(parseInt(qtys[i].replace('>')) + 1) <= qty
								)
							){
								index = i;
							}
						}
							
							
						if(qtys[index+1] !== undefined )
							rule = rules[stage][qtys[index+1]];
						else
							rule = rules[stage][qtys[index]];


						total_res = 0;
						
						for ( var key in states_data[s] ) {
							
							var unit = states_data[s][key],
								option = key;
								
							if ( 
								print_type == 'color' &&
								key == 'colors' && 
								states_data[s][key].length > 0
							) {
								unit = 1;
								option = states_data[s][key].length + '-color';
								option = (typeof rule[option] === 'undefined') ? 'full-color' : option;
								price += (typeof rule[option] !== 'undefined') ? parseFloat(rule[option]) : 0;
							}
							
                            if (
								print_type !== 'color' &&
								typeof rule[option] !== 'undefined'
							) {
                                price += rule[option] * unit;
							}
							
							if ( 
								typeof states_data[s][key] !== 'array' && 
								parseInt(states_data[s][key]) > 0
							) {
								total_res++;
							}
							
                        }
						
						if(
							print_type == 'size' 
							&& total_res > 0
							&& customdesign.data.printings_cfg !== undefined
						){
							var cur = customdesign.cart.printing.current,
								ptrcfg = customdesign.data.printings_cfg,
								product_size = ptrcfg['_'+cur] !== undefined ? ptrcfg['_'+cur] : ptrcfg[cur];
							
							price += (
								typeof product_size !== 'undefined' &&
								typeof rule[product_size] !== 'undefined'
							) ? parseFloat(rule[product_size]) : 0;
							
							if(!print.calculate.multi) 
								return price;
							
						}
						
						if ( print_type == 'fixed' && total_res > 0 ) {
							if ( typeof rule['price'] !== 'undefined' ) {
								price += parseFloat(rule.price);
								if ( !print.calculate.multi ) 
									return price;
							}
						}
						
						indx++;
                        
                    };
                    
					return price;
					
	            }
	        },
	        
	        edit_item			: function (id, e) {
		    	
		    	var items = JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA')),
		    		cart = items[id];
				
				if (cart) {
					customdesign.get.el('general-status').html(
						'<span>\
							<text><i class="customdesignx-android-alert"></i> '+customdesign.i(115)+'</text> \
							<a href="#clear-designs" data-btn="cancel" data-func="clear-designs">\
								'+customdesign.i(185)+'\
							</a>\
						</span>'
					);
					
					customdesign.actions.do('cart_edit', customdesign.apply_filters('cart_edit', cart));
					
					delete data;
				};
				
				if (e && typeof e.preventDefault == 'function')
					e.preventDefault();
		    	 
	        },
	        
	        do_checkout			: function(e) {
		        
		        if (e !== undefined && typeof e.preventDefault == 'function')
		        	e.preventDefault();
		        
		        var donow = function() {
			         try {
		        	
			        	var data = JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA')),
			        		count = 0, 
			        		get_design = function(res){
				        		count ++;
				        		data[res.id].design = res;
				        		
				        		if (count === Object.keys(data).length) {
					        		if(customdesign.apply_filter('custom-checkout',false) === true)
				        			{
				        				customdesign.do_action('custom-checkout', customdesign.apply_filters('checkout', data));
				        			}
				        			else 
				        			{
				        				customdesign.actions.do('checkout', customdesign.apply_filters('checkout', data));
				        			}
				        		} else customdesign.f(false);
				        		
				        	};
			        	
			        	customdesign.f(customdesign.i(44));
			        		
						Object.keys(data).map(function(key) {
							customdesign.indexed.get(key, 'cart', get_design);
						});
						
			        
			        } catch(ex) {
				        console.warn(ex);
						console.log(ex);
				    }
		        };
		        
		        if (customdesign.data.conditions !== '') {
			        var content = customdesign.fn.dejson(customdesign.data.conditions).replace(/\>/g, '&gt;').replace(/\</g, '&lt;')+'<em><input type="checkbox" id="condition-agree" /> <label for="condition-agree">'+customdesign.i(177)+' <font color="red">*</font></label></em>';
			        customdesign.fn.confirm({
						title: content,
						primary: {
							text: customdesign.i(175),
							callback: function(e) {
								if (customdesign.get.el('confirm').find('input[type="checkbox"]').prop('checked') !== true) {
									customdesign.get.el('confirm').find('input[type="checkbox"]').shake();
									return false;
								} else donow();
							}
						},
						second: {}
					});
		        } else donow();
		        
	        }
	        
		},

		load : function() {
			
			this.html = document.querySelector('html');
			this.body = document.querySelector('body');

			if (!this.fn.get_cookie('customdesign-AID'))
				this.fn.set_cookie('customdesign-AID', Math.random().toString(36).substr(2));

			/* 
			*	Start to load when everything is ready 	
			*/
			
			fabric.Object.prototype.set({
			    cornerSize:  this.mode == 'basic' ? 14 : 22,
			    borderColor: 'rgba(205,205,205,0.5)',
			    centeredRotation: true,
			    centeredScaling: true,
			    rotatingPointOffset: this.mode == 'basic' ? 50 : 0,
			});

			for(var n in this.extends.controls) {
				fabric.Object.prototype[n] = this.extends.controls[n];
			};
			
			for(var n in this.extends.canvas) {
				fabric.Canvas.prototype[n] = this.extends.canvas[n];
			};

			this.actions.add('object:selected', function(opts){

				var selected = [],
					s = customdesign.stage(),
					a = s.canvas.getActiveObject(),
					g = s.canvas.getActiveGroup();

				if (customdesign.fn.ctrl_btns(opts) === true)
					return;
				
				/*if (!g && a && a.group_pos) {
					
					opts.target.lockMovementX = true;
					opts.target.lockMovementY = true;
					
					let selected = s.canvas.getObjects().filter(function(o) {
							if (
								o.group_pos && 
								o.group_pos == a.group_pos && 
								o.evented === true && 
								(o.imagebox === undefined || o.imagebox === '')
							) {
								//o.set('active', true);
								return true;
							} else return false;
						}),
						group = new fabric.Group(selected, {
							originX: 'center',
							originY: 'center'
						});
						
					group.setCoords();	
					s.canvas.setActiveGroup(group).renderAll();
					customdesign.tools.set();
				} else */
				
				if (a) {
					selected.push (s.canvas.getActiveObject());
					customdesign.tools.set();
				} else if (g) {
					selected = g._objects;
					customdesign.e.tools.attr({'data-view': 'default'});
				};

				customdesign.e.layers.find('li[data-id].active').removeClass('active');
				
				if (selected.length === 0)
					return;
				
				s.limit_zone.set('visible', true);
				
				if (s.bleed) {
					s.bleed.set('visible', true);
					s.crop_marks.set('visible', true);
				};
				
				selected.forEach(function(obj){
					
					if (obj.selectable !== false)
						customdesign.e.layers.find('li[data-id="'+obj.id+'"]').addClass('active');

				});
				

			});

			this.actions.add('object:added', function(opts){

				var date = new Date(), 
					obj = opts.target, 
					click = false,
					stage = customdesign.stage();

				if (obj.id === undefined)
					obj.set('id', parseInt(date.getTime()/1000).toString(36)+'-'+(Math.random().toString(36).substr(2)));
				else if (obj.id.indexOf(':') > -1)
					obj.set('id', obj.id.replace(/\:/g, '-'));
				else if (obj.id.indexOf('-') === -1)
					obj.set('id', parseInt(date.getTime()/1000).toString(36)+'-'+obj.id);
					
				if (obj.origin_src === undefined && obj._element && obj._element)
					obj.set('origin_src', obj._element.src);

				if (obj.type == 'i-text')
					obj.set('padding', 5);
				
				if (obj.evented === false)
					return;
					
				switch (obj.type) {
					case 'i-text':
						obj.set('thumbn', '<i class="customdesignx-character layer-type" style="color:%color%;background:%bgcolor%"></i>');
					break;
					case 'curvedText':
						obj.set('thumbn', '<i class="customdesignx-vector layer-type" style="color:%color%;background:%bgcolor%"></i>');
					break;
					case 'image':
						
						customdesign.fn.createThumbn({
				    		source: obj.src,
				    		width: 50,
				    		height: 50,
				    		callback: function(canvas) {
								obj.set('thumbn', '<img class="layer-type" style="background:%color%" src="'+(canvas.toDataURL('image/jpeg'))+'" />');
								if (obj.colors === undefined)
									obj.set('colors', customdesign.fn.count_colors(canvas, true));
				    		}
			    		});
							
					break;
					case 'qrcode':
						obj.set('thumbn', '<i class="customdesignx-qrcode-1 layer-type" style="color:%color%;background:%bgcolor%"></i>');
					break;
					case 'path':
						obj.set('thumbn', '<i class="customdesign-icon-graph layer-type" style="color:%color%;background:%bgcolor%"></i>');
					break;
					case 'svg':
						customdesign.fn.createThumbn({
				    		source: obj.src,
				    		width: 24,
				    		height: 24,
				    		callback: function(canvas) {
								obj.set('thumbn', '<img class="layer-type" style="background:%color%" src="'+(canvas.toDataURL('image/jpeg', .5))+'" />');
				    		}
			    		});
					break;
					default:
						obj.set('thumbn', '<i class="customdesign-icon-picture layer-type" style="color:%color%;background:%bgcolor%"></i>');
					break;
				};
				
				customdesign.fn.font_blob(obj);
				
				if (stage.bleed) {
					stage.canvas.bringToFront(stage.bleed);
					setTimeout(() => {
						stage.canvas.setActiveObject(obj).renderAll();
					}, 150);
				}
				
			});
		
			this.actions.add('object:remove', function(){
				customdesign.fn.update_state();
				var stage = customdesign.stage();
				stage.screenshot = customdesign.tools.toImage({
					stage: stage,
					is_bg: 'full', 
					multiplier: 1/window.devicePixelRatio
				});
				
				$('#customdesign-stage-nav img[data-stage="'+customdesign.current_stage+'"]').attr({
					src: stage.screenshot
				});
			});
			
			this.actions.add('selection:cleared', function(){
				customdesign.e.tools.attr({'data-view': 'standard'});
				let s = customdesign.stage();
				customdesign.stage().limit_zone.set('visible', false);
				if (s.bleed) {
					s.bleed.set('visible', false);
					s.crop_marks.set('visible', false);
				}
			});

			this.actions.add('key-move', function(e) {

				var canvas = customdesign.stage().canvas,
					active = canvas.getActiveObject() || canvas.getActiveGroup();
					
				if (active === null || active === undefined)
					return;
					
				var left = active.left,
					top = active.top;

				if (active) {

					e.preventDefault();

					switch (e.keyCode) {

						case 37 : // left
							left = active.left - (e.shiftKey ? 10 : 1);
						break;
						case 38 : // up
							top = active.top - (e.shiftKey ? 10 : 1);
						break;
						case 39 : // right
							left = active.left + (e.shiftKey ? 10 : 1);
						break;
						case 40 : // down
							top = active.top + (e.shiftKey ? 10 : 1);
						break;

					}
					
					if (active.group_pos) {
						canvas.getObjects().map(function(o) {
							if (o.group_pos && o.id != active.id) {
								o.set({
									left: o.left + (left-active.left),
									top: o.top + (top-active.top),
								});
							}
						});
					};
					
					active.set({top: top, left: left});
					canvas.renderAll();
					
				}
			});

			this.actions.add('key-enter', function(e) {
				return customdesign.stage().canvas.deactivateAllWithDispatch().renderAll();
			});

			this.actions.add('key-esc', function(e) {
				if (customdesign.stage().canvas.isDrawingMode === true) {
					customdesign.get.el('discard-drawing').trigger('click');
				}
			});

			this.actions.add('ctrl-z', customdesign.stack.back);

			this.actions.add('ctrl-shift-z', customdesign.stack.forward);

            this.actions.add('ctrl-a', function(e) {
	            
				if (e.target.tagName == 'INPUT' || e.target.getAttribute('contenteditable') !== null) {
					return true;
				}
					
				var canvas = customdesign.stage().canvas;
				var objs = canvas.getObjects().filter(function(o) {
					if (o.evented === true && (o.imagebox === undefined || o.imagebox === '')) {
						o.set('active', true);
						return true;
					} else return false;
				});

				if (objs.length === 0) {
					e.preventDefault();
					return false;
				}

				var group = new fabric.Group(objs, {
				  originX: 'center',
				  originY: 'center'
				});

				canvas._activeObject = null;

				canvas.setActiveGroup(group.setCoords()).renderAll();
				
				customdesign.objects.events['mouse:up'](e);
				
				e.preventDefault();
				return false;

			});

			this.actions.add('ctrl-d', function(e) {

				customdesign.fn.do_double();

				e.preventDefault();
				return false;

			});

			this.actions.add('ctrl+', function(e) {
				customdesign.get.el('zoom').val(parseInt(customdesign.get.el('zoom').val())+20).trigger('input');
				e.preventDefault();
				return false;
			});

			this.actions.add('ctrl-', function(e) {
				customdesign.get.el('zoom').val(parseInt(customdesign.get.el('zoom').val())-20).trigger('input');
				e.preventDefault();
				return false;
			});

			this.actions.add('ctrl-0', function(e) {
				customdesign.get.el('zoom').val(100).trigger('input');
				e.preventDefault();
				return false;
			});

			this.actions.add('ctrl-s', function(e) {
				
				e.preventDefault();
				
				if (customdesign.fn.url_var('cart', '') !== '') {
					return customdesign.cart.add_cart(e);
				} else {
					customdesign.design.my_designs.pre_save();
				};
				
				return false;
				
			});

            this.actions.add('key-delete', function(e) {

            	customdesign.itemInStage('del');

	            var canvas = customdesign.stage().canvas,
	            	objs = canvas.getActiveGroup() ? canvas.getActiveGroup()._objects : canvas.getObjects(),
	            	elms = [];

	            objs.map(function(o){
		            if (o.evented === true && o.active === true)
		            	elms.push(o);
	            });

	            customdesign.stack.save();
	         	customdesign.tools.discard();

	         	elms.map(function(el) {
		         	canvas.remove(el);
	         	});

	            canvas.renderAll();

	            customdesign.stack.save();
				customdesign.design.layers.build();
				
				customdesign.actions.do('object:remove');
				
            });

			this.actions.add('save', customdesign.fn.update_state);
			
			this.actions.add('cart_edit', function(ops) {
				
				$('.customdesign-lightbox').remove();
				
				customdesign.indexed.get(ops.id, 'cart', function(res){
					
					customdesign.fn.load_product({
						id: ops.product,
						cms: ops.product_cms,
						printing: ops.printing,
						options: ops.options,
						template: ops.template, 
						stages: res.stages,
						callback: function(res) {
							
							if (res.id === undefined) {
								customdesign.f(false);
								customdesign.fn.notice('ERROR_LOAD_PRODUCT', 'error', 3500);
								return;
							} else {
								
								customdesign.get.el('general-status').html(
									'<span>\
										<text>\
											<i class="customdesignx-android-alert"></i> '+
											customdesign.i(186)+
										' <strong>#'+ops.id+'</strong></text>\
										<a href="#cancel-design" data-btn="cancel" data-func="cancel-design">\
											'+customdesign.i(187)+'\
										</a>\
									</span>'
								);
								
							}
						}
					});
				});
				
				customdesign.fn.clear_url();
				customdesign.fn.set_url('cart', ops.id);
				
				customdesign.render.cart_change();
				
			});
			
			this.actions.add('active_stage', function(){
				
				var bg = [],
					mo = '';
				
				if (typeof customdesign.cart.printing.states_data[customdesign.current_stage] !== 'undefined'){
					
					var stage_colors = customdesign.cart.printing.states_data[customdesign.current_stage].colors;
					for (var i=0; i<6; i++) {
						if (stage_colors[i])
							bg.push(stage_colors[i]);
					}
					
					if (stage_colors.length > 6)
						mo = (stage_colors.length-6)+'+';
				}
				
				$('#customdesign-count-colors i').html(mo).css({background: 'linear-gradient(to right, '+bg.join(', ')+')'});
				
			});
			
			this.actions.add('db-ready', function(){
				
				try {
					var cart_data = JSON.parse(localStorage.getItem('CUSTOMDESIGN-CART-DATA'));
				}catch(ex){
					var cart_data = null;
				};
				
				var has_cart = false;
				
				if (customdesign.fn.url_var('cart', '') !== '') {
					
					if (cart_data !== null && cart_data[customdesign.fn.url_var('cart')] !== undefined)
						has_cart = true;
					else customdesign.fn.notice(customdesign.i(120), 'error', 3500);
				
				};
				
				if (has_cart === true) {
					
					customdesign.cart.edit_item(customdesign.fn.url_var('cart'));
				
				} else if (customdesign.data.onload) {
					
					customdesign.f(customdesign.i('importing')+'..');
					
					customdesign.fn.set_url('cart', null);
					
					setTimeout(function(){
						
						if (customdesign.data.share !== undefined) {
							Object.keys(customdesign.data.onload.stages).map(function(s){
								delete customdesign.data.onload.stages[s].template;
							});
						};
						
						customdesign.render.product(customdesign.data.onload);
						
						delete customdesign.data.onload;
						
					}, 100);
					
				} else if (customdesign.fn.url_var('reorder', '') === '' && customdesign.get.el('no-product').length > 0) {
					
					customdesign.f(false);
					customdesign.actions.do('noproduct');
					
				};
				
				if (customdesign.data.share_invalid !== undefined) {
					customdesign.fn.confirm({
						title: customdesign.data.share_invalid,
						primary: {},
						second: {
							text: 'Ok'
						},
						type: 'error'
					});
				};
				
				/* Clear unuse cart data in DB */
				var carts = localStorage.getItem('CUSTOMDESIGN-CART-DATA');
				
				if (carts && carts !== '') {
					carts = Object.keys(JSON.parse(carts));
					customdesign.indexed.list(function(data){
						if (carts.indexOf(data.id) === -1)
							customdesign.indexed.delete(data.id, 'cart');
					}, 'cart', function(st){
						if (st == 'done') {
							customdesign.ops.cart_cursor = null;
						}
					});
				}

			});
			
			this.actions.add('first-completed', function(){
				
				if (customdesign.fn.url_var('cart', '') != '') {
					
					customdesign.get.el('general-status').html(
						'<span>\
							<text><i class="customdesignx-android-alert"></i> '+customdesign.i(115)+'</text> \
							<a href="#clear-designs" data-btn="cancel" data-func="clear-designs">\
								'+customdesign.i(185)+'\
							</a>\
						</span>'
					);
					
				} else if (customdesign.fn.url_var('order_print', '') !== '') {
					$('#customdesign-general-status').html(
						'<span>\
							<text>\
								<i class="customdesignx-android-alert"></i> '+
								customdesign.i(122)+' #'+customdesign.fn.url_var('order_print')+
							'</text>\
						</span>'
					);
					if (customdesign.fn.url_var('design_print', '') !== '') {
						
						customdesign.f('Loading..');
						
						var design_path =   customdesign.apply_filters('print-design-url',customdesign.data.upload_url+'designs/' );
						var url = (typeof design_path === "string") ? design_path : customdesign.data.upload_url  +'designs/';

						$.ajax({
							url: url+customdesign.fn.url_var('design_print', '')+'.lumi',
							method: 'GET',
							dataType: 'JSON',
							statusCode: {
								403: customdesign.response.statusCode[403],
								404: function(){
									customdesign.fn.notice(customdesign.i(123), 'error', 3500);
									customdesign.f(false);
								},
								200: function(res) {
									
									if (res === null) {
										customdesign.fn.notice(customdesign.i(166), 'error', 3500);
										customdesign.f(false);
										return;
									};
									
									customdesign.fn.clear_url(['design_print', 'order_print']);
									
									customdesign.fn.load_product({
										id: res.product,
										cms: res.product_cms,
										printing: res.printing,
										options: res.options,
										template: res.template, 
										stages: res.stages,
										callback: function(res) {
											
											if (res.id === undefined) {
												customdesign.f(false);
												customdesign.fn.notice('ERROR_LOAD_PRODUCT', 'error', 3500);
												return;
											} else {
												
												customdesign.get.el('general-status').html(
													'<span>\
														<text>\
															<i class="customdesignx-android-alert"></i> '+
															customdesign.i(192)+
														' <strong>#'+customdesign.fn.url_var('order_print')+'</strong></text>\
													</span>'
												);
												
												//customdesign.get.el('navigations').find('li[data-tool="print"]').trigger('click');
												
											}
										}
									});
									
								}
							}
						});
					}
				}
				
				customdesign.fn.set_url('share', null);
				$('#customdesign-left ul.customdesign-left-nav>li[data-tab]').eq(1).click();
				
			});
			
			this.actions.add('cart-changed', function(){
				
				if (customdesign.fn.url_var('cart', '') === '')
					return;
				
				$('#customdesign-general-status').html(
					'<span>\
						<text>\
							<i class="customdesignx-android-alert"></i> '+
							customdesign.i(116)+': '+customdesign.fn.date('h:m d M, Y', new Date().getTime())+
						'</text>\
						<a href="#cancel-cart" data-btn="cancel" data-func="cancel-cart">\
							'+customdesign.i(117)+'\
						</a>\
					</span>'
				);
				
				//$('#customdesign-general-status button[data-func="save-cart"]').on('click', customdesign.cart.add_cart);
								
			});
			
			this.actions.add('add-cart', function(){
				
				$('#customdesign-general-status').html(
					'<span>\
						<text>'+customdesign.i(118)+'!</text> \
						<a href="#checkout">'+
							customdesign.i(75)+' <i class="customdesignx-android-arrow-forward"></i>\
						</a>\
					</span>'
				);
				
				$('#customdesign-general-status a[href="#checkout"]').on('click', customdesign.cart.do_checkout);
				
			});
			
			this.actions.add('noproduct', function() {
				$('#customdesign-no-product').show();
				customdesign.fn.set_url('cart', null);
				// customdesign.get.el('change-product').trigger('click');
				var flag  = customdesign.apply_filters('no-product');
			    if (flag == false ||  flag == undefined) {
			    	customdesign.get.el('change-product').trigger('click');
			    }
			});
			
			this.actions.add('product', function(data) {
				
				/*
				* Check print permission 
				*/
				
				var priacc = customdesign.get.el('navigations').find('li[data-tool="print"][data-alwd]'),
					priurl = encodeURIComponent(customdesign.fn.url_var('design_print', ''));
				
				if (priacc.length > 0 && priacc.attr('data-alwd') != priurl)
					priacc.remove();
					
			});
			
			this.actions.add('updated', function() {
				if (
					customdesign.fn.url_var('cart', '') === '' &&
					customdesign.fn.url_var('design_print', '') === ''
				) {
					customdesign.get.el('general-status').html(
						'<span>\
							<text><i class="customdesignx-android-alert"></i> '+customdesign.i(189)+'</text>\
							<a href="#save-design" data-func="save-design"><i class="customdesignx-floppy"></i> '+customdesign.i(190)+'</a>\
						</span>'
					);
				}
			});
			
			[
				['ctrl-o', 'import'],
				//['ctrl-s', 'save'],
				['ctrl-e', 'clear'],
				['ctrl-shift-s', 'saveas'],
				['ctrl-p', 'print']
			].map(function(k){
				customdesign.actions.add(k[0], function(e) {
					customdesign.get.el('navigations').find('li[data-tool="file"] li[data-func="'+k[1]+'"]').trigger('click');
					e.preventDefault();
					e.stopPropagation();
					return false;
				});
			});

			fabric.Object.prototype.originX = fabric.Object.prototype.originY = 'center';
			fabric.Object.prototype.transparentCorners = false;
			
			window.CustomdesignDesign = null;
			window.indexedDB = window.indexedDB || 
							   window.webkitIndexedDB || 
							   window.mozIndexedDB || 
							   window.OIndexedDB || 
							   window.msIndexedDB; 
			window.URL = window.URL || window.webkitURL;
			
			CanvasRenderingContext2D.prototype.roundRect = function (x, y, w, h, r) {
				
				if (w < 2 * r) 
					r = w / 2;
				if (h < 2 * r) 
					r = h / 2;
					
				this.beginPath();
				this.moveTo(x+r, y);
				this.arcTo(x+w, y,   x+w, y+h, r);
				this.arcTo(x+w, y+h, x,   y+h, r);
				this.arcTo(x,   y+h, x,   y,   r);
				this.arcTo(x,   y,   x+w, y,   r);
				this.closePath();
				
				return this;
				
				if (w < 1.75 * r) 
					r = w / 1.75;
				if (h < 1.75 * r) 
					r = h / 1.75;
				
				this.beginPath();
				this.moveTo(x+r, y);
				this.arcTo(x+w, y,   x+w, y+h, r);
				this.arcTo(x+w, y+h, x,   y+h, r);
				this.arcTo(x,   y+h, x,   y,   r);
				this.arcTo(x,   y,   x+w, y,   r);
				this.closePath();
				return this;
			};
					
			window.addEventListener('message', function(e) {
				
				if (e.origin != 'https://services.customdesign.com' && e.origin != window.location.origin)
					return;
		
				if (e.data && e.data.action) {
					switch (e.data.action) {
						case 'close_lightbox' :
							$('#customdesign-lightbox').remove();
						break;
						case 'import_image' :
							var id = parseInt(new Date().getTime()/1000).toString(36)+':'+Math.random().toString(36).substr(2);
							if (e.data.ops.name.indexOf('/') > -1)
								e.data.ops.name = e.data.ops.name.split('/').pop();
							customdesign.cliparts.import(id, e.data.ops, 'prepend');
						break;
						case 'add_image' : 
						
							customdesign.fn.preset_import([{type: 'image', url: e.data.url, user_upload: true}]);
						break;
						case 'preview_image': 
							customdesign.get.el('x-thumbn-preview').show().find('>div').html('<img src="'+e.data.ops.url+'" />');
							customdesign.get.el('x-thumbn-preview').find('>header').html(
								(e.data.ops.name ? e.data.ops.name : e.data.ops.url.split('/').pop().substr(0, 50))
							);
							if (e.data.ops.tags !== '')
								customdesign.get.el('x-thumbn-preview').find('>footer').show().html(e.data.ops.tags);
						break;
						case 'close_preview_image': 
							customdesign.get.el('x-thumbn-preview').hide();
						break;
						case 'fonts' :
							customdesign.render.fonts(e.data.fonts);
						break;
						case 'update-svg' :
						
							var canvas = customdesign.stage().canvas;
								active = canvas.getActiveObject();
							
							if (active !== null) {
								
								var src = 'data:image/svg+xml;base64,'+btoa(e.data.svg);
								
								active.set('origin_src', src);
								active.set('src', src);
								active._element.src = src;
								active._originalElement.src = src;
								active._element.onload = function(){
									canvas.renderAll();
								};
							};
							
							customdesign.tools.lightbox('close');
							
						break;
					}
				}
		
			});
			
			window.addEventListener('popstate', function(e, s) {
				if (e) {
					window.location = document.referrer;
					e.preventDefault();
				}
			});
			
			$(window).bind('beforeunload', function(){
				if (customdesign.ops.before_unload)
					return customdesign.ops.before_unload;
			})
			.on('touchstart', function(e){
				
				if ($(e.target).hasClass('smooth'))
					this.smooth = e.target;
				else this.smooth = $(e.target).closest('.smooth').get(0);
				
			})
			.on('touchmove', function(e){
				
				if (e.target === document) {
					e.preventDefault();
					return false;
				}
				
			    if (['INPUT', 'SELECT'].indexOf(e.target.tagName) > -1 || this.smooth)
			    	return true;
			    
		        e.preventDefault();
		        return false;
		        
		    })
		    .on('load', function(){
				customdesign.mobile();
			});
			
			this.design.events();
			this.objects.icons.init();
			
			fabric.util.addListener(fabric.window, 'load', function() {

				var canvas = this.__canvas || this.canvas,
				    canvases = this.__canvases || this.canvases;

				canvas && canvas.calcOffset && canvas.calcOffset();

				if (canvases && canvases.length) {
				  for (var i = 0, len = canvases.length; i < len; i++) {
				    canvases[i].calcOffset();
				  }
				}

			});
			
			////////////////////////////////////////////////

			this.render.colorPresets();
			this.render.fonts();
			this.cart.init();
			
			jscolor.detectDir = function(){ return customdesign.data.assets+'/assets/images/'; };
			jscolor.init();
			delete jscolor.init;
			
			customdesign.mobile();

		},
		
		init : function(n) {
			
			n = n.toUpperCase();
			
			$.ajax({
				url: customdesign.data.ajax,
				method: 'POST',
				data: {
					nonce: 'CUSTOMDESIGN-INIT:'+n,
					ajax: 'frontend',
					action: 'init',
					product_base: customdesign.fn.url_var('product_base', ''),
					product_cms: customdesign.fn.url_var('product_cms', ''),
					share: customdesign.fn.url_var('share', ''),
					quantity: customdesign.fn.url_var('quantity', '1')
				},
				dataType: 'JSON',
				success: function(res) {
					
					if (res.custom_js !== undefined && res.custom_js !== '') {
						try {
							Function("customdesign", res.custom_js)(customdesign);
						} catch (ex) {};
						delete res.custom_js;
					}
					
					$.extend(customdesign.data, res);
					
					customdesign.load();
					
					if (customdesign.indexed.db !== null && typeof customdesign.indexed.onDBReady == 'function') {
						customdesign.indexed.onDBReady();
					};
					
					if (
						typeof(res.onload) !== 'undefined' && 
						typeof(res.onload.id) !== 'undefined' && 
						res.onload.id.toString().indexOf('variable') != -1
					) {
						customdesign.data.calc_formula == '0';
					}
					
				}
			});
			
		}
		
	};

	if (typeof CustomdesignDesign == 'function') {
		customdesign.indexed.init();
		customdesign.init(CustomdesignDesign(customdesign));
	}
	
});