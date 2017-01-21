<%@ WebHandler Language="C#" Class="imageUp" %>
<%@ Assembly Src="Uploader.cs" %>

using System;
using System.Web;
using System.IO;
using System.Collections;

public class imageUp : IHttpHandler
{
    public void ProcessRequest(HttpContext context)
    {
        context.Response.ContentType = "text/plain";

        //�ϴ�����
        string pathbase = "upload/";                                                                    //����·��
        int size = 2;           //�ļ���С����,��λMB                                                                                                   //�ļ���С���ƣ���λMB
        string[] filetype = { ".gif", ".png", ".jpg", ".jpeg", ".bmp" };         //�ļ�������ʽ


        //�ϴ�ͼƬ
        Hashtable info = new Hashtable();
        Uploader up = new Uploader();
        info = up.upFile(context, pathbase, filetype, size);                               //��ȡ�ϴ�״̬

        string title = up.getOtherInfo(context, "pictitle");                              //��ȡͼƬ����

        string oriName = up.getOtherInfo(context, "fileName");                //��ȡԭʼ�ļ���

        HttpContext.Current.Response.Write("{'url':'" + info["url"] + "','title':'" + title + "','original':'" + oriName + "','state':'" + info["state"] + "'}");  //���������������json����
    }

    public bool IsReusable
    {
        get
        {
            return false;
        }
    }

}