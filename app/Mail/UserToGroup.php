<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserToGroup extends Mailable {
	use Queueable, SerializesModels;

	public $groupinfo;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Array $info) {
		$this->groupinfo = $info;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		// $myarray = $this->groupinfo["groupinfo"]["name"];
		// dd($myarray);
		return $this
			->from('groups@TTracker.com')
			->markdown('emails.groups.request')
			->with('groupinfo', $this->groupinfo);
	}
}
