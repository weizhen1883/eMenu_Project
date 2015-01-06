package com.emenu.zhenw.emenucustomersapp;

import android.content.Context;
import android.graphics.Bitmap;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

public class CustomListAdapter extends BaseAdapter {

    private ArrayList<MainActivity.MyItem> mListData;
    private Context mContext;
    private LayoutInflater inflater;

    public CustomListAdapter(Context context, ArrayList<MainActivity.MyItem> listData) {
        mContext = context;
        mListData = listData;
        inflater = LayoutInflater.from(context);
    }

    @Override
    public int getCount() {
        return mListData.size();
    }

    @Override
    public Object getItem(int position) {
        return mListData.get(position);
    }

    @Override
    public long getItemId(int position) {
        return position;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View v = convertView;
        CuisineHolder holder = new CuisineHolder();

        if (convertView == null) {
            // This a new view we inflate the new layout
            inflater = (LayoutInflater) mContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
            v = inflater.inflate(R.layout.cuisine, null);
            // Now we can fill the layout with the right values
            holder.cuisineNameView = (TextView) v.findViewById(R.id.cuisineName);
            holder.cuisinePriceView = (TextView) v.findViewById(R.id.cuisinePrice);
            holder.cuisineIntroView = (TextView) v.findViewById(R.id.cuisineDescription);
            holder.cuisineImageView = (ImageView) v.findViewById(R.id.cuisineImage);

            v.setTag(holder);
        } else {
            holder = (CuisineHolder) v.getTag();
        }
        MainActivity.MyItem item = mListData.get(position);
        holder.cuisineNameView.setText(item.name);
        holder.cuisinePriceView.setText(item.price);
        holder.cuisineIntroView.setText(item.intro);
        holder.cuisineImageView.setImageBitmap(item.image);
        return v;
    }

    private static class CuisineHolder {
        public TextView cuisineNameView;
        public TextView cuisineIntroView;
        public TextView cuisinePriceView;
        public ImageView cuisineImageView;
    }
}
