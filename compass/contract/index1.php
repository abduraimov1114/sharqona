<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <!--PDF-->
    <link rel="stylesheet" href="include/pdf/pdf.viewer.css">
    <!--PPTX-->
    <link rel="stylesheet" href="include/PPTXjs/css/pptxjs.css">
    <link rel="stylesheet" href="include/PPTXjs/css/nv.d3.min.css">
    <!--All Spreadsheet -->
    <link rel="stylesheet" href="include/SheetJS/handsontable.full.min.css">
    <!--Image viewer-->
    <link rel="stylesheet" href="include/verySimpleImageViewer/css/jquery.verySimpleImageViewer.css">
    <link rel="stylesheet" href="include/officeToHtml/officeToHtml.css">
</head>
<body>
<div id="resolte-contaniner"></div>
<input type="file" id="select_file" />
<script>
    var file_path = "resource/service_original_doc.docx";
    $("#resolte-contaniner").officeToHtml({
        url: file_path
    });
    $("#resolte-contaniner").officeToHtml({
        inputObjId: "select_file"
    });
    $("#resolte-contaniner").officeToHtml({
        url: file_path,
        inputObjId: "select_file",
        pdfSetting: {
            // setting for pdf
        },
        docxSetting: {
            // setting for docx
        },
        pptxSetting: {
            // setting for pptx
        },
        sheetSetting: {
            // setting for excel
        },
        imageSetting: {
            // setting for  images
        }
    });
    $("#resolte-contaniner").officeToHtml({
        url: file_path,
        inputObjId: "select_file",
        pdfSetting: {
            setLang: "ru",
            thumbnailViewBtn: true,
            searchBtn: true,
            nextPreviousBtn: true,
            pageNumberTxt: true,
            totalPagesLabel: true,
            zoomBtns: true,
            scaleSelector: true,
            presantationModeBtn: true,
            openFileBtn: true,
            printBtn: true,
            downloadBtn: true,
            bookmarkBtn: true,
            secondaryToolbarBtn: true,
            firstPageBtn: true,
            lastPageBtn: true,
            pageRotateCwBtn: true,
            pageRotateCcwBtn: true,
            cursorSelectTextToolbarBtn: true,
            cursorHandToolbarBtn: true
        }
    });
    $("#resolte-contaniner").officeToHtml({
        url: file_path,
        inputObjId: "select_file",
        docxSetting: {
            styleMap : null,
            includeEmbeddedStyleMap: true,
            includeDefaultStyleMap: true,
            convertImage: null,
            ignoreEmptyParagraphs: false,
            idPrefix: "",
            isRtl : "auto"
        }
    });
    $("#resolte-contaniner").officeToHtml({
        url: file_path,
        inputObjId: "select_file",
        pptxSetting: {
            slidesScale: "50%", //Change Slides scale by percent
            slideMode: true, /** true,false*/
            keyBoardShortCut: true,  /** true,false ,condition: slideMode: true*/
            mediaProcess: true, /** true,false: if true then process video and audio files */
            jsZipV2: false,
            slideModeConfig: {
                first: 1,
                nav: true, /** true,false : show or not nav buttons*/
                navTxtColor: "black", /** color */
                keyBoardShortCut: false, /** true,false ,condition: */
                showSlideNum: true, /** true,false */
                showTotalSlideNum: true, /** true,false */
                autoSlide:1, /** false or seconds , F8 to active ,keyBoardShortCut: true */
                randomAutoSlide: false, /** true,false ,autoSlide:true */
                loop: true,  /** true,false */
                background: false, /** false or color*/
                transition: "default", /** transition type: "slid","fade","default","random" , to show transition efects :transitionTime > 0.5 */
                transitionTime: 1 /** transition time between slides in seconds */
            }
        }
    });
    $("#resolte-contaniner").officeToHtml({
        url: file_path,
        inputObjId: "select_file",
        sheetSetting: {
            jqueryui : false,
            activeHeaderClassName: "",
            allowEmpty: true,
            autoColumnSize: true,
            autoRowSize: false,
            columns: false,
            columnSorting: true,
            contextMenu: false,
            copyable: true,
            customBorders: false,
            fixedColumnsLeft: 0,
            fixedRowsTop: 0,
            language:'en-US',
            search: false,
            selectionMode: 'single',
            sortIndicator: false,
            readOnly: false,
            startRows: 1,
            startCols: 1,
            rowHeaders: true,
            colHeaders: true,
            width: false,
            height:false
        }
    });
    $("#resolte-contaniner").officeToHtml({
        url: file_path,
        inputObjId: "select_file",
        imageSetting: {
            frame: ['100%', '100%',false],
            maxZoom: '900%',
            zoomFactor: '10%',
            mouse: true,
            keyboard: true,
            toolbar: true,
            rotateToolbar: false
        }
    });
</script>
<script src="include/pdf/pdf.js"></script> <!--Docs-->
<script src="include/docx/jszip-utils.js"></script>
<script src="include/docx/mammoth.browser.min.js"></script>
<script type="text/javascript" src="include/PPTXjs/js/filereader.js"></script>
<script type="text/javascript" src="include/PPTXjs/js/d3.min.js"></script>
<script type="text/javascript" src="include/PPTXjs/js/nv.d3.min.js"></script>
<script type="text/javascript" src="include/PPTXjs/js/pptxjs.js"></script>
<script type="text/javascript" src="include/PPTXjs/js/divs2slides.js"></script>
<script type="text/javascript" src="include/SheetJS/handsontable.full.min.js"></script>
<script type="text/javascript" src="include/SheetJS/xlsx.full.min.js"></script>
<script type="text/javascript" src="include/verySimpleImageViewer/js/jquery.verySimpleImageViewer.js"></script>
<!--officeToHtml-->
<script src="include/officeToHtml/officeToHtml.js"></script>
</body>
</html>
