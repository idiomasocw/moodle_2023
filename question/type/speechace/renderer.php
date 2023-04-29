<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * SpeechAce question renderer class.
 *
 * @package    qtype
 * @subpackage speechace
 * @copyright  2017 SpeechAce
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once("constant.php");
require_once("speechacelib.php");
global $PAGE;

$PAGE->requires->jquery();
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/question/type/speechace/module.js'));

/**
 * Generates the output for speechace questions.
 */
class qtype_speechace_renderer extends qtype_renderer {
    public function formulation_and_controls(question_attempt $qa,
        question_display_options $options) {

        $question = $qa->get_question();
        $responseoutput = $question->get_format_renderer($this->page);

        // Answer field.
        $answer = $responseoutput->response_area_input(
                    'answer',
                    $qa,
                    $options->context,
                    !empty($options->readonly));
        
        $result = '';
        $result .= $question->format_questiontext($qa);

        $result .= html_writer::start_tag('div');
        $result .= html_writer::tag('div', $answer);
        $result .= html_writer::end_tag('div');

        return $result;
    }
    
    public function manual_comment(question_attempt $qa, question_display_options $options) {

        $result = "";

        return $result;
    }
}

/**
 * An speechace format renderer for speechace for audio
 *
 * @copyright  2017 SpeechAce
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_speechace_format_audio_renderer extends plugin_renderer_base {

    protected function class_name() {
        return 'qtype_speechace_audio';
    }

    protected function prepare_response_for_editing($name,
        question_attempt_step $step, $context) {
        return $step->prepare_response_files_draft_itemid_with_text(
            $name, $context->id, $step->get_qt_var($name));

    }

    public function response_area_input($name, $qa, $context, $read_only) {
        $step = $qa->get_last_step_with_qt_var($name);
        //check of we already have a submitted answer. If so we need to set the filename
        //in our input field.
        $submittedfilename = strip_tags($step->get_qt_var($name));
        $submittedfile = qtype_speechace_get_submitted_file($name, $qa, $submittedfilename, $context->id);
        if (!$submittedfile) {
            $submittedfilename = '';
        }

        $ret = "";
        $draftitemid = null;
        $inputid = null;

        if (!$read_only) {
            //prepare a draft file id for use
            list($draftitemid, $response) = $this->prepare_response_for_editing( $name, $step, $context);

            //prepare the tags for our hidden( or shown ) input
            $inputname = $qa->get_qt_field_name($name);
            $inputid =  $inputname . '_id';

            //our answerfield
            $ret .= html_writer::empty_tag('input', array('type' => 'hidden','id'=>$inputid,
                'name' => $inputname, 'value' => $submittedfilename));

            //our answerfield draft id key
            $ret .= html_writer::empty_tag('input', array('type' => 'hidden', 'name' => $inputname . ':itemid', 'value'=> $draftitemid));

            //our answerformat
            $ret .= html_writer::empty_tag('input', array('type' => 'hidden','name' => $inputname . 'format', 'value' => 1));
        }

        //the context id is the user context for a student submission
        return $ret . $this->render_moodle_view_controller(
                        $inputid,
                        $context->id,
                        'user',
                        'draft',
                        $draftitemid,
                        $qa,
                        $submittedfile,
                        $read_only);
    }

    protected function render_moodle_view_controller(
        $updatecontrol,
        $contextid,
        $component,
        $filearea,
        $itemid,
        $qa,
        $submittedfile,
        $read_only)
    {
        global $PAGE, $CFG;

        $PAGE->requires->js(new moodle_url($CFG->wwwroot . QTYPE_SPEECHACE_JS_PATH));

        $baseurl = $CFG->wwwroot . '/question/type/speechace/jsapi.php';
        $domid = $qa->get_qt_field_name('speechace-recording-view-controller');
        $opts = array();
        $opts['updatecontrol'] = $updatecontrol;
        $opts['contextid'] = $contextid;
        $opts['component'] = $component;
        $opts['filearea'] = $filearea;
        $opts['itemid'] = $itemid;
        $opts['baseurl'] = $baseurl;
        $opts['requestid'] = 'audiorecorder_' . time() .  rand(10000,999999);
        $opts['domid'] = $domid;
        $opts['slot'] = $qa->get_slot();
        $opts['usageid'] = $qa->get_usage_id();
        $opts['sesskey'] = sesskey();

        $opts['workerPath'] = $CFG->wwwroot . '/question/type/speechace/js/recorderWorker.js';
        $opts['swfPath'] = $CFG->wwwroot . QTYPE_SPEECHACE_SWF_PATH;
        $opts['preferSwf'] = QTYPE_SPEECHACE_PREFER_SWF;
        $opts['fillColor'] = '#fff';
        $opts['color'] = '#1ccff6';
        $opts['volumeFillColor'] = '#bbb';
        $opts['readOnly'] = $read_only;
        $opts['phonemeSymbolType'] = 'ipa';

        if ($submittedfile) {
            $opts['answerId']=strip_tags($submittedfile->get_filename());
        }

        $opts['id'] =  $qa->get_qt_field_name('id');

        $question = $qa->get_question();
        $question_args = json_decode($question->scoringinfo);
        if ($question_args->score_type === "scoreword") {
            $opts['word'] = $question->get_answer_to_show($question_args->text, $read_only);
        } else {
            $opts['text'] = $question->get_answer_to_show($question_args->text, $read_only);
        }
        if ($question->showanswer == QTYPE_SPEECHACE_SHOW_ANSWER_ALWAYS) {
            $opts['expertAudioPos'] = 'top';
        } else {
            $opts['expertAudioPos'] = 'middle';
        }
        $scoringinfo_obj = new qtype_speechace_scoringinfo($question_args);
        $opts['experthash'] = $scoringinfo_obj->getExpertHash();
        $opts['dialect']= $question->dialect;
        $opts['showExpertAudio']= $question->get_expertaudio_to_show($read_only);
        $questionimg = qtype_speechace_get_question_img_src($question_args);
        if ($questionimg) {
            $opts['image'] = $questionimg;
        }

        $showNumericScore =  qtype_speechace_get_show_numeric_score();
        if ($showNumericScore =="1")
             $opts['showNumericScore'] = true;
        else
            $opts['showNumericScore'] = false;

        $scoreMessagesData = qtype_speechace_deserialize_score_message_setting(get_config('qtype_speechace','scoremessages'));
        $opts['scoremessagesTextOne'] = $scoreMessagesData[QTYPE_SPEECHACE_SCOREMESSAGES_TEXTONE];
        $opts['scoremessagesTextTwo'] = $scoreMessagesData[QTYPE_SPEECHACE_SCOREMESSAGES_TEXTTWO];
        $opts['scoremessagesTextThree'] = $scoreMessagesData[QTYPE_SPEECHACE_SCOREMESSAGES_TEXTTHREE];
        $PAGE->requires->js_init_call("M.qtype_speechace.attachMoodleViewController", array($opts), false);

        $output = "";
        $output .= "<div id=\"" . $domid . "\"></div>";

        return $output;
    }
}
