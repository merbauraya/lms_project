<xsl:stylesheet xmlns:zs="http://www.loc.gov/zing/srw/" xmlns:marc="http://www.loc.gov/MARC21/slim" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0" exclude-result-prefixes="marc zs">
<xsl:output method="xml" indent="yes"/>

<xsl:template match="/">
<xsl:choose>
	<xsl:when test="zs:searchRetrieveResponse/zs:numberOfRecords &gt; 1">
		<collection xmlns="http://www.loc.gov/MARC21/slim"> 

		<xsl:for-each select="zs:searchRetrieveResponse/zs:records/zs:record/zs:recordData">
			<xsl:copy-of  select="*" />
		</xsl:for-each>

		</collection>
	</xsl:when>
	<xsl:otherwise>
		<xsl:copy-of select="zs:searchRetrieveResponse/zs:records/zs:record/zs:recordData/*" />	
				
	</xsl:otherwise>
</xsl:choose>

</xsl:template>
</xsl:stylesheet>