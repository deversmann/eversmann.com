// Created by iWeb 2.0.4 local-build-20090406

function createMediaStream_id4()
{return IWCreatePhotocast("http://www.eversmann.com/eversmann/Pictures_files/rss.xml",true,true);}
function initializeMediaStream_id4()
{createMediaStream_id4().load('http://www.eversmann.com/eversmann',function(imageStream)
{var entryCount=imageStream.length;var headerView=widgets['widget1'];headerView.setPreferenceForKey(imageStream.length,'entryCount');NotificationCenter.postNotification(new IWNotification('SetPage','id4',{pageIndex:0}));});}
function layoutMediaGrid_id4(range)
{createMediaStream_id4().load('http://www.eversmann.com/eversmann',function(imageStream)
{if(range==null)
{range=new IWRange(0,imageStream.length);}
IWLayoutPhotoGrid('id4',new IWPhotoGridLayout(3,new IWSize(182,182),new IWSize(182,35),new IWSize(218,232),27,27,0,new IWSize(19,19)),new IWPhotoFrame([IWCreateImage('Pictures_files/Watercolor_iweb_01.png'),IWCreateImage('Pictures_files/Watercolor_iweb_02.png'),IWCreateImage('Pictures_files/Watercolor_iweb_04.png'),IWCreateImage('Pictures_files/Watercolor_iweb_08.png'),IWCreateImage('Pictures_files/Watercolor_iweb_16.png'),IWCreateImage('Pictures_files/Watercolor_iweb_14.png'),IWCreateImage('Pictures_files/Watercolor_iweb_13.png'),IWCreateImage('Pictures_files/Watercolor_iweb_05.png')],null,0,0.800000,0.000000,0.000000,0.000000,0.000000,12.000000,12.000000,11.000000,11.000000,13.000000,12.000000,13.000000,12.000000,null,null,null,0.500000),imageStream,range,null,null,1.000000,{backgroundColor:'#000000',reflectionHeight:100,reflectionOffset:2,captionHeight:100,fullScreen:0,transitionIndex:2},'Media/slideshow.html','widget1','widget2','widget3')});}
function relayoutMediaGrid_id4(notification)
{var userInfo=notification.userInfo();var range=userInfo['range'];layoutMediaGrid_id4(range);}
function onStubPage()
{var args=getArgs();parent.IWMediaStreamPhotoPageSetMediaStream(createMediaStream_id4(),args.id);}
if(window.stubPage)
{onStubPage();}
setTransparentGifURL('Media/transparent.gif');function hostedOnDM()
{return false;}
function onPageLoad()
{IWRegisterNamedImage('comment overlay','Media/Photo-Overlay-Comment.png')
IWRegisterNamedImage('movie overlay','Media/Photo-Overlay-Movie.png')
IWRegisterNamedImage('contribution overlay','Media/Photo-Overlay-Contribution.png')
loadMozillaCSS('Pictures_files/PicturesMoz.css')
adjustLineHeightIfTooBig('id1');adjustFontSizeIfTooBig('id1');adjustLineHeightIfTooBig('id2');adjustFontSizeIfTooBig('id2');adjustLineHeightIfTooBig('id3');adjustFontSizeIfTooBig('id3');NotificationCenter.addObserver(null,relayoutMediaGrid_id4,'RangeChanged','id4')
Widget.onload();fixupAllIEPNGBGs();fixAllIEPNGs('Media/transparent.gif');fixupIECSS3Opacity('id5');initializeMediaStream_id4()
performPostEffectsFixups()}
function onPageUnload()
{Widget.onunload();}
