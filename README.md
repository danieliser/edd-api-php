This sdk includes a complete set of models for the data returned via the EDD API v2.

There are multiple query methods already, each returns valid results in the form of objects or null.

Check out the following sample code to get you started. Read the Easy Digital Downloads [API Reference](http://docs.easydigitaldownloads.com/category/1130-api-reference) for more information on how to obtain keys and tokens.

    /**
     * Load the sdk if its not already available.
     */
     if ( ! function_exists( 'edd_api' ) ) {
        // Load the sdk.
        require_once( 'edd-api-sdk/edd-api-sdk.php' );
    }
    
    /**
     * Call our own instance of the edd_api.
     */
    function _edd_api() {
        return edd_api( array(
            'url' => EDD_API_URL,
            'key' => EDD_API_KEY,
            'token' => EDD_API_TOKEN,
        ));
    }

    /**
     * Get products from the api and render them with category & earnings.
     */
    function _render_products_with_total_earnings( $number = -1 ) {
        $products = _edd_api()->get_products( array( 'number' => $number ) );
    
        foreach ( $products as $product ) {
            /**
             * @var $product EDD_API_Model_Product
             */
    
            // Get only the first category.
            $category = $product->category ? $product->category[0]->name : 'Uncategorized';
    
            // [Category] Product Title: $1,000,000.00
            echo "[{$category}] {$product->title}: \${$product->total_earnings} \r\n";
        }
    }