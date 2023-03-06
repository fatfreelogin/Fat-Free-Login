<?php

class datetime_utils_DateTimeMonthUtils {
	public function __construct() {}
	static function days($month, $isLeapYear = null) { if(!php_Boot::$skip_constructor) {
		if($isLeapYear === null) {
			$isLeapYear = false;
		}
		if($month === 1) {
			return 31;
		} else {
			if($month === 2 && $isLeapYear) {
				return 29;
			} else {
				if($month === 2) {
					return 28;
				} else {
					if($month === 3) {
						return 31;
					} else {
						if($month === 4) {
							return 30;
						} else {
							if($month === 5) {
								return 31;
							} else {
								if($month === 6) {
									return 30;
								} else {
									if($month === 7) {
										return 31;
									} else {
										if($month === 8) {
											return 31;
										} else {
											if($month === 9) {
												return 30;
											} else {
												if($month === 10) {
													return 31;
												} else {
													if($month === 11) {
														return 30;
													} else {
														return 31;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}}
	static function getMonth($days, $isLeapYear = null) {
		if($isLeapYear === null) {
			$isLeapYear = false;
		}
		if($days < 32) {
			return 1;
		} else {
			if($isLeapYear) {
				if($days < 61) {
					return 2;
				} else {
					if($days < 92) {
						return 3;
					} else {
						if($days < 122) {
							return 4;
						} else {
							if($days < 153) {
								return 5;
							} else {
								if($days < 183) {
									return 6;
								} else {
									if($days < 214) {
										return 7;
									} else {
										if($days < 245) {
											return 8;
										} else {
											if($days < 275) {
												return 9;
											} else {
												if($days < 306) {
													return 10;
												} else {
													if($days < 336) {
														return 11;
													} else {
														return 12;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			} else {
				if($days < 60) {
					return 2;
				} else {
					if($days < 91) {
						return 3;
					} else {
						if($days < 121) {
							return 4;
						} else {
							if($days < 152) {
								return 5;
							} else {
								if($days < 182) {
									return 6;
								} else {
									if($days < 213) {
										return 7;
									} else {
										if($days < 244) {
											return 8;
										} else {
											if($days < 274) {
												return 9;
											} else {
												if($days < 305) {
													return 10;
												} else {
													if($days < 335) {
														return 11;
													} else {
														return 12;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	static function getMonthDay($days, $isLeapYear = null) {
		if($isLeapYear === null) {
			$isLeapYear = false;
		}
		if($days < 32) {
			return $days;
		} else {
			if($isLeapYear) {
				if($days < 61) {
					return $days - 31;
				} else {
					if($days < 92) {
						return $days - 60;
					} else {
						if($days < 122) {
							return $days - 91;
						} else {
							if($days < 153) {
								return $days - 121;
							} else {
								if($days < 183) {
									return $days - 152;
								} else {
									if($days < 214) {
										return $days - 182;
									} else {
										if($days < 245) {
											return $days - 213;
										} else {
											if($days < 275) {
												return $days - 244;
											} else {
												if($days < 306) {
													return $days - 274;
												} else {
													if($days < 336) {
														return $days - 305;
													} else {
														return $days - 335;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			} else {
				if($days < 60) {
					return $days - 31;
				} else {
					if($days < 91) {
						return $days - 59;
					} else {
						if($days < 121) {
							return $days - 90;
						} else {
							if($days < 152) {
								return $days - 120;
							} else {
								if($days < 182) {
									return $days - 151;
								} else {
									if($days < 213) {
										return $days - 181;
									} else {
										if($days < 244) {
											return $days - 212;
										} else {
											if($days < 274) {
												return $days - 243;
											} else {
												if($days < 305) {
													return $days - 273;
												} else {
													if($days < 335) {
														return $days - 304;
													} else {
														return $days - 334;
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	static function toSeconds($month, $isLeapYear = null) {
		if($isLeapYear === null) {
			$isLeapYear = false;
		}
		return 86400 * ((($month === 1) ? 0 : (($isLeapYear) ? (($month === 2) ? 31 : (($month === 3) ? 60 : (($month === 4) ? 91 : (($month === 5) ? 121 : (($month === 6) ? 152 : (($month === 7) ? 182 : (($month === 8) ? 213 : (($month === 9) ? 244 : (($month === 10) ? 274 : (($month === 11) ? 305 : 335)))))))))) : (($month === 2) ? 31 : (($month === 3) ? 59 : (($month === 4) ? 90 : (($month === 5) ? 120 : (($month === 6) ? 151 : (($month === 7) ? 181 : (($month === 8) ? 212 : (($month === 9) ? 243 : (($month === 10) ? 273 : (($month === 11) ? 304 : 334)))))))))))));
	}
	function __toString() { return 'datetime.utils.DateTimeMonthUtils'; }
}
