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
 * Strings for component 'qtype_speechace', language 'en', branch 'MOODLE_20_STABLE'
 *
 * @package    qtype
 * @subpackage speechace
 * @copyright  2017 SpeechAce
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['speechace'] = 'SpeechAce';
$string['pluginname'] = 'SpeechAce';
$string['pluginname_help'] = 'In response to a question the respondent speaks the text. SpeechAce automatically assigns a grade based on how well the speech is.';
$string['pluginname_link'] = 'question/type/speechace';
$string['pluginnameadding'] = 'Adding a SpeechAce scoring question';
$string['pluginnameediting'] = 'Editing a SpeechAce scoring question';
$string['pluginnamesummary'] = 'Allows a speech response for a piece of English text. SpeechAce grades the speech automatically based on how close the speech is to General American pronunciation and accent.';
$string['scoringinfo'] = 'Answer Text';
$string['scoringinfo_help'] = 'Specify the word, sentence or paragraph text that the student is expected to speak. You may include any necessary punctuation. 
Furthermore, you may provide a reference audio by either recording your own voice or automatically generating an audio by pressing the refresh button. The reference audio will have to be regenerated each time the specified text is modified.';

$string['dialect_default'] = 'Default Dialect';
$string['dialect'] = 'Dialect';
$string['dialect_description'] = 'Default Dialect for Speechace scoring and reference audio in new questions.';
$string['dialect_us_english'] = 'US English';
$string['dialect_gb_english'] = 'UK English';
$string['dialectinfomissing'] = 'Dialect info is missing';
$string['dialectinfoinvalid'] = 'Dialect value is invalid';
$string['dialect_default_temp'] = 'Dialect temp';
$string['yesoption'] = 'Yes';
$string['nooption'] = 'No';
$string['numericscore']= 'Numeric Score';
$string['numericscore_default']= 'Yes';
$string['numericscore_description']= 'Default is to show the percentage score';
$string['numericscore_descritptivename'] = 'Show percentage score';
$string['scoremessages'] = 'Scoring Messages';
$string['scoremessages_description'] = 'To Write and Customize the text upon question evaluation';
$string['scoremessages_defaultinfo'] = 'Click Reset Messages for defaults';
$string['scoremessages_default_textOne'] = "You got it! Are you a native speaker?";
$string['scoremessages_default_textTwo']= "You are not bad.";
$string['scoremessages_default_textThree']= "That doesn't sound good. You can try again.";
$string['showanswer'] = 'Show Answer Text';
$string['showanswer_always'] = 'Always';
$string['showanswer_result'] = 'When SpeechAce score is shown';
$string['showresult'] = 'Show SpeechAce Score';
$string['showresult_immediately'] = 'Immediately after recording';
$string['showresult_review'] = 'During quiz review';
$string['showexpertaudio'] = 'Show Reference Audio';
$string['showexpertaudio_always'] = 'Always';
$string['showexpertaudio_result'] = 'When SpeechAce score is shown';
$string['showexpertaudio_missing']= 'Reference Audio is missing';
$string['showexpertaudio_infoinvalid']= 'Reference Value is invalid';
$string['pleaserecordaudio'] = 'Please record your audio.';
$string['productkey'] = 'Product Key';
$string['productkey_description'] = 'Product key from SpeechAce to access SpeechAce web service.';
$string['productkeyempty'] = 'Product key cannot be empty.';
$string['productkeyinvalid'] = 'Product key is invalid.';
$string['scoringinfomissing'] = 'Missing input for information for computer scoring';
$string['scoringinfotextmissing'] = 'Please provide the text for scoring';
$string['scoringinfotextunknownerror'] = 'Unable to validate the text for scoring';
$string['scoringinfotextoutofvocab'] = 'Some of the words in the text are not allowed: {$a->detail_message}';
$string['scoringinfotexttoolong'] = 'The text is too long. Make sure that it is less than {$a->detail_message} characters.';
$string['scoringinfosourcetypeinvalid'] = 'Invalid selection. Please select "Use your audio" or "Use SpeechAce audio"';
$string['scoringinfomoodlekeygenericerror'] = 'Unable to validate your audio. Please try saving again, recording another audio, or using SpeechAce audio.';
$string['scoringinfomoodlekeydetailmessage'] = 'Encountered error validing your audio: {$a->detail_message} Please try saving again, recording another audio, or using SpeechAce audio.';
$string['error_productkey_missing'] = 'SpeechAce product key is not set. If you are an administrator, please specify it at Site administration -> Plugins -> Question types -> SpeechAce';
$string['error_productkey_invalid'] = 'SpeechAce product key is not valid. If you are an administrator, please provide a valid product key at Site administration -> Plugins -> Question types -> SpeechAce';
$string['error_productkey_expired'] = 'SpeechAce product key has expired. If you are an administrator, please contact SpeechAce for renewal';
$string['error_http_api_call'] = 'SpeechAce was unable to access remote service. If you are an administrator, please contact SpeechAce for help';
