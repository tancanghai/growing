var COM={
	/**
	 * 生成一个用不重复的ID
	 * 函数将生成类似 8dlv9vabygks2cbg1spds4i 的ID
	 */
	GenNonDuplicateID:function (){
	 return Math.random().toString(36).substr(3);
	}
}

export default COM;
